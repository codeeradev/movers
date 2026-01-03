<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PropertyImport;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subcategory;

use Carbon\Carbon;
class PlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Dropdown data
    $sectors = Sector::all();
    $categories = Category::all();
    $subcategories = Subcategory::all();
        return view('admin.plots.index', compact('sectors','categories','subcategories'));
    }

    /**
     * Get Data for DataTables
     */
      public function getData(Request $request)
    {
       // dd($request->all());
        $columns = [
            'id', 'owner_name', 'contact_number', 
            'property_type', 'property_number', 'dob',
            'location', 'price', 'status'
        ];

        $query = Property::query();
        
    // Sector Filter
    if ($request->sector_id && $request->sector_id !== "") {
        $query->where('sector_id', $request->sector_id);
    }

    // Category Filter
    if ($request->category_id && $request->category_id !== "") {
        $query->where('category_id', $request->category_id);
    }


    // Subcategory Filter
    if ($request->subcategory_id && $request->subcategory_id !== "") {
        $query->where('subcategory_id', $request->subcategory_id);
    }
    if ($request->property_number && $request->property_number !== "") {
    $query->where('id', $request->property_number);
}
if ($request->has('property_status') && $request->property_status !== "") {
    $query->where('property_status', $request->property_status);
}


        // Searching
        if (!empty($request->search['value'])) {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('owner_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%")
                  ->orWhere('property_type', 'like', "%{$search}%")
                  ->orWhere('property_number', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
            });
        }

        $totalRecords = Property::count();
        $filteredRecords = $query->count();

        // Sorting
        if ($request->has('order')) {
            $columnIndex = $request->order[0]['column'] ?? 0;
            $columnName = $columns[$columnIndex] ?? 'id';
            $columnSortOrder = $request->order[0]['dir'] ?? 'desc';
            $query->orderBy($columnName, $columnSortOrder);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Pagination
        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $plots = $query->skip($start)->take($length)->get();

        // Format Data
        $data = $plots->map(function ($plot) {
                  // Convert property_status using config
        $propertyStatusText = config('constants.property_status')[$plot->property_status] 
                              ?? '-';
            return [
                'id' => $plot->id,
                'owner_name' => e($plot->owner_name),
                'dob' => e($plot->dob ?? '-'),
                'contact_number' => e($plot->contact_number ?? '-'),
                'property_status' => e($propertyStatusText),
                'property_number' => e($plot->property_number ?? '-'),
                'location' => e($plot->location ?? '-'),
                'price' => $plot->price ? '₹' . number_format($plot->price, 2) : '-',
                'status' => $plot->status == 1 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-danger">Inactive</span>',
              'actions' => '
    <div class="d-flex justify-content-center gap-2">
        <a href="' . route('plots.edit', $plot->id) . '" 
            class="btn btn-sm btn-outline-primary" title="Edit">
            <i class="bi bi-pencil"></i>
        </a>' 
        . (auth()->user()->role == 1 ? '
        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" 
            data-id="' . $plot->id . '" title="Delete">
            <i class="bi bi-trash"></i>
        </button>' : '') . '
    </div>'

            ];
        });

        // Return JSON for DataTables
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Show form for creating new plot
     */
   public function create()
{
    $sectors = Sector::orderBy('name')->get(['id', 'name']);
    $categories = Category::orderBy('name')->get(['id', 'name']);
    $subcategories = Subcategory::orderBy('name')->get(['id', 'name', 'category_id']);

    return view('admin.plots.create', compact('sectors', 'categories', 'subcategories'));
}

    /**
     * Store new plot
     */
 

public function store(Request $request)
{
    $validated = $request->validate([
        'owner_name'      => 'required|string|max:255',
        'father_name'     => 'nullable|string|max:255',
        'contact_number'  => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255',
        'dob'             => 'nullable|date_format:d-m-Y',
        'address'         => 'nullable|string|max:255',

        // property_type is now direct text field
        'property_type'   => 'nullable|string|max:100',

        'property_number' => 'nullable|string|max:100',
        'khewat_number'   => 'nullable|string|max:100',
        'khasra_number'   => 'nullable|string|max:100',
        'plot_size'       => 'nullable|string|max:100',

        // sector/category/subcategory still dropdown + custom
        'sector_id'       => 'nullable',
        'sector_custom'   => 'nullable|string|max:255',
        'category_id'     => 'nullable',
        'category_custom' => 'nullable|string|max:255',
        'subcategory_id'  => 'nullable',
        'subcategory_custom' => 'nullable|string|max:255',

        // ownership_type is now simple input
        'ownership_type'  => 'nullable|string|max:100',

        'location'        => 'required|string|max:255',
        'landmark'        => 'nullable|string|max:255',
        'price'           => 'nullable|numeric|min:0',
        'description'     => 'nullable|string',

        'status'          => 'nullable|boolean',
        'property_status' => 'nullable|in:1,2',

        'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Convert DOB
    if (!empty($validated['dob'])) {
        $validated['dob'] = Carbon::createFromFormat('d-m-Y', $validated['dob'])->format('Y-m-d');
    }

    /* ---------------------- IMAGE UPLOAD ---------------------- */
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '-' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move(public_path('plots'), $filename);
        $validated['image'] = $filename;
    }

    /* ---------------------- SECTOR ---------------------- */
    if ($request->sector_id === 'other' && $request->filled('sector_custom')) {
        $sector = Sector::firstOrCreate(
            ['name' => trim($request->sector_custom)],
            ['code' => trim($request->sector_custom)]
        );
        $validated['sector_id'] = $sector->id;
    }

    /* ---------------------- CATEGORY ---------------------- */
    if ($request->category_id === 'other' && $request->filled('category_custom')) {
        $category = Category::firstOrCreate(
            ['name' => trim($request->category_custom)],
            ['code' => trim($request->category_custom)]
        );
        $validated['category_id'] = $category->id;
    }

    /* ---------------------- SUBCATEGORY ---------------------- */
    if ($request->subcategory_id === 'other' && $request->filled('subcategory_custom')) {
        $subcategory = Subcategory::firstOrCreate(
            ['name' => trim($request->subcategory_custom)],
            [
                'code' => trim($request->subcategory_custom),
                'category_id' => $validated['category_id'] ?? null,
            ]
        );
        $validated['subcategory_id'] = $subcategory->id;
    }

    /* ---------------------- CLEANED OWNERSHIP TYPE ----------------------
       No dropdown, so no 'other' handling required
    ------------------------------------------------------------------- */

    /* ---------------------- CLEANED PROPERTY TYPE ----------------------
       No dropdown, so no 'other' handling required
    ------------------------------------------------------------------- */

    // Save property
    Property::create($validated);

    return redirect()->route('plots.index')->with('success', 'Property added successfully!');
}


public function show($id)
{
    $plot = Property::with(['sector', 'category', 'subcategory'])
        ->findOrFail($id);

    return view('admin.plots.show', compact('plot'));
}


    /**
     * Edit plot
     */
   public function edit($id)
{
    $property = Property::findOrFail($id);
    $sectors = Sector::orderBy('name')->get(['id', 'name']);
    $categories = Category::orderBy('name')->get(['id', 'name']);
    $subcategories = Subcategory::orderBy('name')->get(['id', 'name', 'category_id']);
 

    return view('admin.plots.create', compact('property', 'sectors', 'categories', 'subcategories'));
}

    /**
     * Update plot
     */
   public function update(Request $request, $id)
{
    $plot = Property::findOrFail($id);

    $validated = $request->validate([
        'owner_name'      => 'required|string|max:255',
        'father_name'     => 'nullable|string|max:255',
        'contact_number'  => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255',
        'dob'             => 'nullable|date_format:d-m-Y',
        'address'         => 'nullable|string|max:255',

        // Simple text field now
        'property_type'   => 'nullable|string|max:100',

        'property_number' => 'nullable|string|max:100',
        'khewat_number'   => 'nullable|string|max:100',
        'khasra_number'   => 'nullable|string|max:100',
        'plot_size'       => 'nullable|string|max:100',

        'location'        => 'required|string|max:255',
        'landmark'        => 'nullable|string|max:255',
        'price'           => 'nullable|numeric|min:0',
        'description'     => 'nullable|string',

        // Simple text field now
        'ownership_type'  => 'nullable|string|max:100',

        'status'          => 'nullable|boolean',
        'property_status' => 'nullable|in:1,2',

        'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    /* ---------------- DOB Convert ---------------- */
    if (!empty($validated['dob'])) {
        $validated['dob'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['dob'])
            ->format('Y-m-d');
    }

    /* ---------------- IMAGE UPLOAD ---------------- */
    if ($request->hasFile('image')) {

        $file = $request->file('image');
        $filename = time() . '-' . preg_replace('/\s+/', '-', $file->getClientOriginalName());

        // delete old image
        if ($plot->image && file_exists(public_path('plots/' . $plot->image))) {
            unlink(public_path('plots/' . $plot->image));
        }

        $file->move(public_path('plots'), $filename);
        $validated['image'] = $filename;

    } else {
        // keep old image
        $validated['image'] = $plot->image;
    }

    /* ----------- Simple update (all clean) ------------ */
    $plot->update($validated);

    return redirect()->route('plots.index')->with('success', 'Plot updated successfully!');
}

    /**
     * Delete plot
     */
    public function destroy($id)
    {
        $plot = Property::findOrFail($id);

        if ($plot->image && file_exists(public_path('plots/' . $plot->image))) {
            unlink(public_path('plots/' . $plot->image));
        }

        $plot->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Plot deleted successfully.']);
        }

        return redirect()->route('plots.index')->with('success', 'Plot deleted successfully!');
    }
public function import(Request $request)
{

     ini_set('max_execution_time', 300);
    ini_set('memory_limit', '512M');
    $request->validate([
        'file' => 'required|mimes:xlsx,xls|max:2048',
    ]);

    try {
        \Log::info("Excel Import Started by: " . auth()->user()->name ?? 'System');

        // Capture how many rows imported successfully
        $before = \App\Models\Property::count();
        Excel::import(new \App\Imports\PropertyImport, $request->file('file'));
        $after = \App\Models\Property::count();

        $imported = $after - $before;

        \Log::info("Excel Import Completed — Imported {$imported} records successfully.");

        return response()->json([
            'success' => true,
            'message' => 'File imported successfully!',
            'total'   => $imported,
        ]);

    } catch (\Throwable $e) {
        \Log::error("Excel Import Failed: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => "Import failed: " . $e->getMessage(),
        ], 500);
    }
}

public function globalSearchAjax(Request $request)
{
    $q = trim($request->q);

    // If no text + no filters → return empty
    if (!$q && !$request->sector_id && !$request->category_id && !$request->subcategory_id) {
        return response()->json([]);
    }

    // Break input into multiple keywords
    $keywords = $q ? preg_split('/\s+/', $q) : [];

    $query = Property::with(['sector', 'category', 'subcategory']);

    /* -------------------------
       TEXT SEARCH (KEYWORDS)
    -------------------------- */
    if (!empty($keywords)) {
        foreach ($keywords as $word) {
            $query->where(function($sub) use ($word) {
                $sub->where('owner_name', 'LIKE', "%{$word}%")
                    ->orWhere('father_name', 'LIKE', "%{$word}%")
                    ->orWhere('contact_number', 'LIKE', "%{$word}%")
                    ->orWhere('property_number', 'LIKE', "%{$word}%")
                    ->orWhere('plot_size', 'LIKE', "%{$word}%")
                    ->orWhere('location', 'LIKE', "%{$word}%")
                    ->orWhere('price', 'LIKE', "%{$word}%")
                   ->orWhere('address', 'LIKE', "%{$word}%")
                    // Match sector
                    ->orWhereHas('sector', function($q2) use ($word) {
                        $q2->where('name', 'LIKE', "%{$word}%");
                    })

                    // Match category
                    ->orWhereHas('category', function($q2) use ($word) {
                        $q2->where('name', 'LIKE', "%{$word}%");
                    })

                    // Match subcategory
                    ->orWhereHas('subcategory', function($q2) use ($word) {
                        $q2->where('name', 'LIKE', "%{$word}%");
                    });
            });
        }
    }

    /* -------------------------
       FILTERS APPLY HERE
    -------------------------- */

    // Sector Filter
    if ($request->sector_id && $request->sector_id !== "") {
        $query->where('sector_id', $request->sector_id);
    }

    // Category Filter
    if ($request->category_id && $request->category_id !== "") {
        $query->where('category_id', $request->category_id);
    }


    // Subcategory Filter
    if ($request->subcategory_id && $request->subcategory_id !== "") {
        $query->where('subcategory_id', $request->subcategory_id);
    }
    if ($request->property_id && $request->property_id !== "") {
    $query->where('id', $request->property_id);
}
if ($request->has('property_status') && $request->property_status !== "") {
    $query->where('property_status', $request->property_status);
}

    /* -------------------------
       FINAL RESULT
    -------------------------- */
    return response()->json(
        $query->orderBy('id', 'DESC')->limit(100)->get()
    );
}

public function filterProperties(Request $request)
{
    $query = Property::query();

    if ($request->sector_id) {
        $query->where('sector_id', $request->sector_id);
    }

    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->subcategory_id) {
        $query->where('subcategory_id', $request->subcategory_id);
    }


    $properties = $query->select('id', 'property_number')
        ->orderBy('property_number')
        ->get();

    return response()->json($properties);
}






}
