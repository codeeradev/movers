<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarProcess;

class CarProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('admin.car-process.index');
    }
    public function ajaxData(Request $request)
{
    $draw   = intval($request->get('draw'));
    $start  = intval($request->get('start', 0));
    $length = intval($request->get('length', 10));
    $search = $request->get('search')['value'] ?? '';

    // Total records (without filter)
    $recordsTotal = CarProcess::count();

    $query = CarProcess::query();

    // Search filter
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Total records (with filter)
    $recordsFiltered = $query->count();

    // Data with pagination
    $data = $query
        ->orderBy('sort_order', 'asc')
        ->offset($start)
        ->limit($length)
        ->get();

    $finalData = [];
    $sr = $start + 1;

    foreach ($data as $row) {
        $finalData[] = [
            'sr_no'      => $sr++,
            'title'      => $row->title,
            'image'      => $row->image
                ? '<img src="/uploads/car-process/'.$row->image.'" height="40">'
                : '-',
            'status'     => $row->status
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-secondary">Inactive</span>',
            'sort_order' => $row->sort_order,
          'action' => '
<div class="action-btns d-flex gap-1">
    <a href="'.route('car-process.edit', $row->id).'" 
       class="btn btn-sm btn-info">
       Edit
    </a>

    <button 
        class="btn btn-sm btn-danger delete-btn"
        data-id="'.$row->id.'">
        Delete
    </button>
</div>
',

        ];
    }

    return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data'            => $finalData,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.car-process.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order'  => 'nullable|integer',
        'status'      => 'required|in:0,1',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only([
        'title',
        'description',
        'sort_order',
        'status',
    ]);

    // 🔹 Image Upload
    if ($request->hasFile('image')) {
        $image      = $request->file('image');
        $imageName  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('uploads/car-process'), $imageName);

        $data['image'] = $imageName;
    }

    // 🔹 Default sort order (if empty)
    if (empty($data['sort_order'])) {
        $data['sort_order'] = 0;
    }

    // 🔹 Save to DB
    \App\Models\CarProcess::create($data);

    return redirect()
        ->route('car-process.index')
        ->with('success', 'Car shifting step added successfully.');
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
    $process = CarProcess::findOrFail($id);

    return view('admin.car-process.edit', compact('process'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, $id)
{
    $process = \App\Models\CarProcess::findOrFail($id);

    // 🔥 CASE 1: Only IMAGE update (from gallery page)
    if ($request->hasFile('image') && !$request->has('title')) {

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // delete old image
        if ($process->image && file_exists(public_path('uploads/car-process/' . $process->image))) {
            unlink(public_path('uploads/car-process/' . $process->image));
        }

        $image     = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/car-process'), $imageName);

        $process->update([
            'image' => $imageName
        ]);

        return back()->with('success', 'Image updated successfully.');
    }

    // 🔥 CASE 2: Full form update (edit page)
    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'sort_order'  => 'nullable|integer',
        'status'      => 'required|in:0,1',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->only([
        'title',
        'description',
        'sort_order',
        'status',
    ]);

    // image update (optional)
    if ($request->hasFile('image')) {

        if ($process->image && file_exists(public_path('uploads/car-process/' . $process->image))) {
            unlink(public_path('uploads/car-process/' . $process->image));
        }

        $image     = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/car-process'), $imageName);

        $data['image'] = $imageName;
    }

    if ($data['sort_order'] === null) {
        $data['sort_order'] = 0;
    }

    $process->update($data);

    return redirect()
        ->route('car-process.index')
        ->with('success', 'Car shifting step updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{
    $process = \App\Models\CarProcess::findOrFail($id);

    // delete image
    if (!empty($process->image) && file_exists(public_path('uploads/car-process/' . $process->image))) {
        unlink(public_path('uploads/car-process/' . $process->image));
    }

    $process->delete();

    return response()->json([
        'status' => true,
        'message' => 'Step deleted successfully'
    ]);
}
public function gallery()
{
    $processes = \App\Models\CarProcess::orderBy('sort_order')->get();

    return view('admin.car-process.gallery', compact('processes'));
}
public function removeImage($id)
{
    $process = \App\Models\CarProcess::findOrFail($id);

    if ($process->image && file_exists(public_path('uploads/car-process/'.$process->image))) {
        unlink(public_path('uploads/car-process/'.$process->image));
    }

    $process->image = null;
    $process->save();

    return response()->json([
        'status' => true,
        'message' => 'Image removed successfully'
    ]);
}

}
