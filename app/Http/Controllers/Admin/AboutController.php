<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function index()
    {
        return view('admin.about.index');
    }



public function ajax(Request $request)
{
    $draw   = intval($request->draw);
    $start  = intval($request->start);
    $length = intval($request->length);
    $search = $request->search['value'] ?? '';

    $recordsTotal = About::count();

    $query = About::query();

    if ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
    }

    $recordsFiltered = $query->count();

    $data = $query
        ->latest()
        ->offset($start)
        ->limit($length)
        ->get();

    $final = [];
    $sr = $start + 1;

    foreach ($data as $row) {
        $final[] = [
            'sr' => $sr++,
            'title' => $row->title,
          'description' => '
<a href="javascript:void(0)"
   class="view-detail text-primary font-weight-bold"
   data-id="'.$row->id.'">
   '.Str::limit(strip_tags($row->description), 80).'
</a>
',
            'image' => $row->image
                ? '<img src="/uploads/about/'.$row->image.'" height="40">'
                : '-',
            'status' => $row->status
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-secondary">Inactive</span>',
            'action' => '
                <a href="'.route('about.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
                <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
            ',
        ];
    }

    return response()->json([
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $final,
    ]);
}


    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'required|string',
            'vision'      => 'nullable|string',
            'mission'     => 'nullable|string',
            'status'      => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $name = time().'_'.$img->getClientOriginalName();
            $img->move(public_path('uploads/about'), $name);
            $data['image'] = $name;
        }

        About::create($data);

        return redirect()->route('about.index')
            ->with('success', 'About content added successfully');
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'required|string',
            'vision'      => 'nullable|string',
            'mission'     => 'nullable|string',
            'status'      => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($about->image && file_exists(public_path('uploads/about/'.$about->image))) {
                unlink(public_path('uploads/about/'.$about->image));
            }

            $img = $request->file('image');
            $name = time().'_'.$img->getClientOriginalName();
            $img->move(public_path('uploads/about'), $name);
            $data['image'] = $name;
        }

        $about->update($data);

        return redirect()->route('about.index')
            ->with('success', 'About content updated successfully');
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);

        if ($about->image && file_exists(public_path('uploads/about/'.$about->image))) {
            unlink(public_path('uploads/about/'.$about->image));
        }

        $about->delete();

        return response()->json(['status' => true]);
    }

    public function show($id)
    {
        $about = \App\Models\About::findOrFail($id);

        return response()->json([
            'title'       => $about->title,
            'subtitle'    => $about->subtitle,
            'description' => $about->description,
            'vision'      => $about->vision,
            'mission'     => $about->mission,
            'image'       => $about->image
                ? asset('uploads/about/'.$about->image)
                : null,
            'status'      => $about->status ? 'Active' : 'Inactive',
        ]);
    }

}
