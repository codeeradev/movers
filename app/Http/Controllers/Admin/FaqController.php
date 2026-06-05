<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faqs.index');
    }

    public function ajax(Request $request)
    {
        $draw = (int) $request->draw;
        $start = (int) $request->start;
        $length = (int) $request->length;
        $search = $request->input('search.value', '');

        $query = Faq::with(['service', 'blog']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%")
                    ->orWhere('scope', 'like', "%{$search}%")
                    ->orWhereHas('service', function ($serviceQuery) use ($search) {
                        $serviceQuery->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('blog', function ($blogQuery) use ($search) {
                        $blogQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $recordsTotal = Faq::count();
        $recordsFiltered = $query->count();

        $data = $query
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        $rows = [];
        $sr = $start + 1;

        foreach ($data as $row) {
            $rows[] = [
                'sr' => $sr++,
                'question' => Str::limit(e($row->question), 80),
                'answer' => '<a href="javascript:void(0)" class="view-detail text-primary font-weight-bold" data-id="'.$row->id.'">'.Str::limit(strip_tags($row->answer), 90).'</a>',
                'scope' => $row->scope === 'service'
                    ? 'Service'
                    : ($row->scope === 'blog' ? 'Blog' : 'Home'),
                'target' => $row->scope === 'service'
                    ? e(optional($row->service)->title ?? '-')
                    : ($row->scope === 'blog'
                        ? e(optional($row->blog)->title ?? '-')
                        : 'Home Page'),
                'service' => $row->scope === 'service'
                    ? e(optional($row->service)->title ?? '-')
                    : '-',
                'blog' => $row->scope === 'blog'
                    ? e(optional($row->blog)->title ?? '-')
                    : '-',
                'sort_order' => $row->sort_order,
                'status' => $row->status
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Inactive</span>',
                'action' => '
                    <div class="action-btns">
                        <a href="'.route('faqs.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
                    </div>
                ',
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows,
        ]);
    }

    public function create()
    {
        $services = Service::where('status', 1)->orderBy('sort_order')->orderBy('id')->get();
        $blogs = Blog::where('status', 1)->latest()->get();

        return view('admin.faqs.create', compact('services', 'blogs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'scope' => 'required|in:home,service,blog',
            'service_id' => 'nullable|required_if:scope,service|exists:services,id',
            'blog_id' => 'nullable|required_if:scope,blog|exists:blogs,id',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['service_id'] = $data['scope'] === 'service' ? $data['service_id'] : null;
        $data['blog_id'] = $data['scope'] === 'blog' ? $data['blog_id'] : null;

        Faq::create($data);

        return redirect()->route('faqs.index')->with('success', 'FAQ added successfully.');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $services = Service::where('status', 1)->orderBy('sort_order')->orderBy('id')->get();
        $blogs = Blog::where('status', 1)->latest()->get();

        return view('admin.faqs.edit', compact('faq', 'services', 'blogs'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $data = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'scope' => 'required|in:home,service,blog',
            'service_id' => 'nullable|required_if:scope,service|exists:services,id',
            'blog_id' => 'nullable|required_if:scope,blog|exists:blogs,id',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['service_id'] = $data['scope'] === 'service' ? $data['service_id'] : null;
        $data['blog_id'] = $data['scope'] === 'blog' ? $data['blog_id'] : null;

        $faq->update($data);

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json(['status' => true, 'message' => 'FAQ deleted successfully']);
    }

    public function show($id)
    {
        $faq = Faq::findOrFail($id);

        return response()->json([
            'question' => $faq->question,
            'answer' => $faq->answer,
            'scope' => $faq->scope,
            'service' => optional($faq->service)->title,
            'blog' => optional($faq->blog)->title,
            'sort_order' => $faq->sort_order,
            'status' => $faq->status ? 'Active' : 'Inactive',
        ]);
    }
}
