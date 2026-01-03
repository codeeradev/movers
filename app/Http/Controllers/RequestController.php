<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Property;
use App\Models\Request as ClientRequest; 
class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('admin.requests.index');
    }


   public function getData(Request $request)
{
    $columns = [
        'id', 'client_name', 'contact_number', 
        'type', 'sector_id', 'category_id',
        'location', 'status', 'created_at'
    ];

    // Load relations
    $query = ClientRequest::with(['sector', 'category', 'subcategory']);
  
if ($request->has('type') && $request->type != '') {
    $query->where('type', $request->type)
          ->where('status', 2);
}


    // Searching
    if (!empty($request->search['value'])) {
        $search = $request->search['value'];
        $query->where(function ($q) use ($search) {
            $q->where('client_name', 'like', "%{$search}%")
              ->orWhere('contact_number', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('notes', 'like', "%{$search}%");
        });
    }

    $totalRecords = ClientRequest::count();
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

    $rows = $query->skip($start)->take($length)->get();

    // Map data
    $data = $rows->map(function ($item) {
        return [
            'id' => $item->id,
            'client_name' => e($item->client_name),
            'contact_number' => e($item->contact_number),
            'type' => config("constants.request_types.{$item->type}", 'Unknown'),

            // ✔ Relation names here
            'sector' => $item->sector->name ?? '-',
            'category' => $item->category->name ?? '-',
            'subcategory' => $item->subcategory->name ?? '-',

            'location' => e($item->location ?? '-'),

         'status' => config("constants.request_statuses.{$item->status}", 'Unknown'),


            'created_at' => $item->created_at
                ? $item->created_at->format('d-m-Y H:i')
                : '-',

            'actions' => '
                <div class="d-flex justify-content-center gap-2">
                    <a href="' . route('property-requests.edit', $item->id) . '" 
                        class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete" 
                        data-id="' . $item->id . '" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>'
        ];
    });

    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $sectors = Sector::all();
    $categories = Category::all();
    $subcategories = Subcategory::all();
        $properties = [];

    return view('admin.requests.create', compact('sectors', 'categories', 'subcategories', 'properties'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'client_name'     => 'required|string|max:255',
            'contact_number'  => 'required|string|max:20',
            'type'            => 'required|integer',
    
            'sector_id'       => 'nullable|integer|exists:sectors,id',
            'category_id'     => 'nullable|integer|exists:categories,id',
            'subcategory_id'  => 'nullable|integer|exists:subcategories,id',
    
            'location'        => 'nullable|string|max:255',
            'status'          => 'nullable|integer',
            'notes'           => 'nullable|string',
    
            'property_id'     => 'nullable',
            'is_new_plot'     => 'nullable|string'
        ]);
    
    
        /* ---------------------------------------------------------
           CASE 1: NEW PLOT → create using full property structure
        ----------------------------------------------------------*/
        if ($request->is_new_plot === "true") {
    
            $newPropertyData = [
                'owner_name'       => $request->client_name,
                'father_name'      => NULL,
                'contact_number'   => $request->contact_number,
                'email'            => NULL,
                'dob'              => NULL,
                'address'          => NULL,
                'property_type'    => NULL,
                'property_number'  => $request->new_property_id,
                'khewat_number'    => NULL,
                'khasra_number'    => NULL,
                'plot_size'        => NULL,
                'sector_id'        => $request->sector_id,
                'category_id'      => $request->category_id,
                'subcategory_id'   => $request->subcategory_id,
                'ownership_type'   => NULL,
                'location'         => $request->location ?? '',
                'landmark'         => NULL,
                'price'            => NULL,
                'description'      => NULL,
                'status'           => 1,
                'property_status'  => 1,
                'image'            => NULL
            ];
    
            // Create the new property
            $createdProperty = Property::create($newPropertyData);
    
            // Use created ID for ClientRequest
            $validated['property_id'] = $createdProperty->id;
        }
    
    
        /* ---------------------------------------------------------
           CASE 2: EXISTING PLOT → use existing ID
        ----------------------------------------------------------*/
        else {
            $validated['property_id'] = $request->property_id;
        }
    
    
        /* ---------------------------------------------------------
           Create Client Request
        ----------------------------------------------------------*/
        ClientRequest::create($validated);
    
        return redirect()->route('property-requests.index')
            ->with('success', 'Request created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
    {
        $requestData = ClientRequest::findOrFail($id);
//dd( $requestData );
        return view('admin.requests.edit', [
            'requestData'   => $requestData,
            'sectors'       => Sector::all(),
            'categories'    => Category::all(),
            'subcategories' => Subcategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'client_name'      => 'required|string|max:255',
        'contact_number'   => 'required|string|max:20',
        'type'             => 'required',
        'sector_id'        => 'nullable|exists:sectors,id',
        'category_id'      => 'nullable|exists:categories,id',
        'subcategory_id'   => 'nullable|exists:subcategories,id',
        'location'         => 'required|string',
        'status'           => 'required|integer',
        'notes'            => 'nullable|string',
        'property_id'      => 'nullable|integer|exists:properties,id',  // <-- added
    ]);

    $clientRequest = ClientRequest::findOrFail($id);

    $clientRequest->update([
        'client_name'      => $request->client_name,
        'contact_number'   => $request->contact_number,
        'type'             => $request->type,
        'sector_id'        => $request->sector_id,
        'category_id'      => $request->category_id,
        'subcategory_id'   => $request->subcategory_id,
        'location'         => $request->location,
        'status'           => $request->status,
        'notes'            => $request->notes,
        'property_id'      => $request->property_id ?? null,  // <-- added
    ]);

    return redirect()
        ->route('property-requests.index')
        ->with('success', 'Request updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    try {
        $requestData = ClientRequest::findOrFail($id);

        $requestData->delete();

        return response()->json([
            'success' => true,
            'message' => 'Request deleted successfully.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete request.'
        ], 500);
    }
}
public function matchingList()
{
    $matches = ClientRequest::from('requests as buy')
        ->select(
            'buy.id as buy_id',
            'buy.client_name as buy_name',
            'buy.contact_number as buy_contact',
            'buy.location as buy_location',
            'sell.id as sell_id',
            'sell.client_name as sell_name',
            'sell.contact_number as sell_contact',
            'sell.location as sell_location',
            'buy.sector_id',
            'buy.category_id',
            'buy.subcategory_id',
            'buy.property_id'
        )
        ->join('requests as sell', function ($join) {
            $join->on('sell.sector_id', '=', 'buy.sector_id')
                ->on('sell.category_id', '=', 'buy.category_id')
                ->on('sell.subcategory_id', '=', 'buy.subcategory_id')
                ->on('sell.property_id', '=', 'buy.property_id')   // <-- Added property match
                ->where('sell.type', 2)
                ->where('sell.status', 2);
        })
        ->where('buy.type', 1)
        ->where('buy.status', 2)
        ->get();

    return view('admin.matching.index', compact('matches'));
}


public function updateMatchStatus(Request $request)
{
    $request->validate([
        'buy_id'     => 'required|integer',
        'sell_id'    => 'required|integer',
        'buy_status' => 'required|integer',
        'sell_status'=> 'required|integer',
    ]);

    // Update Buyer
    ClientRequest::where('id', $request->buy_id)
        ->update([
            'status' => $request->buy_status
        ]);

    // Update Seller
    ClientRequest::where('id', $request->sell_id)
        ->update([
            'status' => $request->sell_status
        ]);

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully'
    ]);
}

}
