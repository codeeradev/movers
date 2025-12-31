<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /* ===========================
       INDEX PAGE
    ============================ */
    public function index()
    {
        return view('admin.testimonials.index');
    }

    /* ===========================
       DATATABLE AJAX
    ============================ */
    public function ajax(Request $request)
    {
        $draw   = intval($request->draw);
        $start  = intval($request->start);
        $length = intval($request->length);
        $search = $request->search['value'] ?? '';

        $recordsTotal = Testimonial::count();

        $query = Testimonial::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
        }

        $recordsFiltered = $query->count();

        $data = $query
            ->orderBy('sort_order')
            ->offset($start)
            ->limit($length)
            ->get();

        $finalData = [];
        $sr = $start + 1;

        foreach ($data as $row) {
            $finalData[] = [
                'sr_no' => $sr++,
                'name'  => $row->name,
                'image' => $row->image
                    ? '<img src="/uploads/testimonials/'.$row->image.'" height="40" class="rounded-circle">'
                    : '-',
                'message' => Str::limit($row->message, 70),
                'status' => $row->status
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Inactive</span>',
                'sort_order' => $row->sort_order,
                'action' => '
                    <div class="action-btns">
                        <a href="'.route('testimonials.edit', $row->id).'" 
                           class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="'.$row->id.'">Delete</button>
                    </div>
                '
            ];
        }

        return response()->json([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $finalData,
        ]);
    }

    /* ===========================
       CREATE PAGE
    ============================ */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /* ===========================
       STORE
    ============================ */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => 'nullable|string|max:255',
            'message'    => 'required|string',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name',
            'position',
            'message',
            'status',
            'sort_order',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $data['image'] = $imageName;
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        Testimonial::create($data);

        return redirect()
            ->route('testimonials.index')
            ->with('success', 'Testimonial added successfully.');
    }

    /* ===========================
       EDIT PAGE
    ============================ */
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /* ===========================
       UPDATE
    ============================ */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => 'nullable|string|max:255',
            'message'    => 'required|string',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name',
            'position',
            'message',
            'status',
            'sort_order',
        ]);

        if ($request->hasFile('image')) {

            // delete old image
            if ($testimonial->image && file_exists(public_path('uploads/testimonials/'.$testimonial->image))) {
                unlink(public_path('uploads/testimonials/'.$testimonial->image));
            }

            $image = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $data['image'] = $imageName;
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $testimonial->update($data);

        return redirect()
            ->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /* ===========================
       DELETE (AJAX)
    ============================ */
    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->image && file_exists(public_path('uploads/testimonials/'.$testimonial->image))) {
            unlink(public_path('uploads/testimonials/'.$testimonial->image));
        }

        $testimonial->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }
}
