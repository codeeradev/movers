<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    // 📄 Blog List
    public function index()
    {
      
        return view('admin.blogs.index');
    }



public function ajax(Request $request)
{
    $draw   = intval($request->draw);
    $start  = intval($request->start);
    $length = intval($request->length);
    $search = $request->search['value'] ?? '';

    // Total records
    $recordsTotal = Blog::count();

    $query = Blog::query();

    // Search
    if ($search) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhere('summary', 'like', "%{$search}%")
              ->orWhere('short_description', 'like', "%{$search}%");
    }

    $recordsFiltered = $query->count();

    // Fetch data
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

            // Summary clickable → modal
            'summary' => '
                <a href="javascript:void(0)"
                   class="view-detail text-primary font-weight-bold"
                   data-id="'.$row->id.'">
                   '.Str::limit(strip_tags($row->summary), 80).'
                </a>
            ',

            // Image
            'image' => $row->image
                ? '<img src="/uploads/blogs/'.$row->image.'" height="40">'
                : '-',

            // Status badge
            'status' => $row->status
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-secondary">Inactive</span>',

            // Action buttons
            'action' => '
                <a href="'.route('blogs.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
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


    // ➕ Create Form
    public function create()
    {
        return view('admin.blogs.create');
    }

    // 💾 Store Blog
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'summary' => 'required|max:400',
        'short_description' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    $imageName = null;

    if ($request->hasFile('image')) {
        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/blogs'), $imageName);
    }

    Blog::create([
        'title' => $request->title,
        'slug' => \Str::slug($request->title),
        'summary' => $request->summary,
        'short_description' => $request->short_description,
        'image' => $imageName,
        'author' => 'Admin',
        'status' => $request->status,
    ]);

    return redirect()->route('blogs.index')
        ->with('success', 'Blog created successfully');
}

    // ✏️ Edit Form
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blogs.edit', compact('blog'));
    }

    // 🔄 Update Blog
   public function update(Request $request, $id)
{
    $blog = Blog::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'summary' => 'required|max:400',
        'short_description' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status' => 'required|in:0,1',
    ]);

    // Handle image update
    if ($request->hasFile('image')) {

        // delete old image
        if ($blog->image && file_exists(public_path('uploads/blogs/'.$blog->image))) {
            unlink(public_path('uploads/blogs/'.$blog->image));
        }

        $imageName = time().'_'.$request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/blogs'), $imageName);

        $blog->image = $imageName;
    }

    $blog->update([
        'title' => $request->title,
        'slug' => \Str::slug($request->title),
        'summary' => $request->summary,
        'short_description' => $request->short_description,
        'status' => $request->status,
    ]);

    return redirect()->route('blogs.index')
        ->with('success', 'Blog updated successfully');
}


    // 🗑 Delete Blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image && file_exists(public_path('uploads/blogs/' . $blog->image))) {
            unlink(public_path('uploads/blogs/' . $blog->image));
        }

        $blog->delete();

        return redirect()->route('blogs.index')
            ->with('success', 'Blog deleted successfully');
    }
}
