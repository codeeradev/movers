<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    private function ensureUploadDirectory(): void
    {
        $path = public_path('uploads/services');

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function index()
    {
        return view('admin.services.index');
    }

    public function ajax(Request $request)
    {
        $draw = intval($request->draw);
        $start = intval($request->start);
        $length = intval($request->length);
        $search = $request->search['value'] ?? '';

        $recordsTotal = Service::count();
        $query = Service::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $rows = $query->latest()->offset($start)->limit($length)->get();
        $final = [];
        $sr = $start + 1;

        foreach ($rows as $row) {
            $final[] = [
                'sr' => $sr++,
                'title' => $row->title,
                'image' => $row->image ? '<img src="'.asset('uploads/services/'.$row->image).'" height="42" class="rounded">' : '-',
                'description' => '<a href="javascript:void(0)" class="view-detail text-primary font-weight-bold" data-id="'.$row->id.'">'.Str::limit(strip_tags($row->description), 80).'</a>',
                'status' => $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>',
                'action' => '
                    <a href="'.route('admin-services.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
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
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $this->ensureUploadDirectory();

            $image = $request->file('image');
            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/services'), $name);
            $data['image'] = $name;
        }

        $data['slug'] = Str::slug($data['title']);
        $baseSlug = $data['slug'];
        $counter = 1;
        while (Service::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $baseSlug.'-'.$counter++;
        }

        Service::create($data);

        return redirect()->route('admin-services.index')->with('success', 'Service created successfully');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image && file_exists(public_path('uploads/services/'.$service->image))) {
                unlink(public_path('uploads/services/'.$service->image));
            }

            $this->ensureUploadDirectory();

            $image = $request->file('image');
            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/services'), $name);
            $data['image'] = $name;
        }

        $data['slug'] = Str::slug($data['title']);
        $baseSlug = $data['slug'];
        $counter = 1;
        while (Service::where('slug', $data['slug'])->where('id', '!=', $service->id)->exists()) {
            $data['slug'] = $baseSlug.'-'.$counter++;
        }

        $service->update($data);

        return redirect()->route('admin-services.index')->with('success', 'Service updated successfully');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && file_exists(public_path('uploads/services/'.$service->image))) {
            unlink(public_path('uploads/services/'.$service->image));
        }

        $service->delete();

        return response()->json(['status' => true]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);

        return response()->json([
            'title' => $service->title,
            'description' => $service->description,
            'image' => $service->image ? asset('uploads/services/'.$service->image) : null,
            'status' => $service->status ? 'Active' : 'Inactive',
        ]);
    }
}
