<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return view('admin.contact-messages.index');
}
public function ajax(Request $request)
{
    $draw   = intval($request->draw);
    $start  = intval($request->start);
    $length = intval($request->length);
    $search = $request->input('search.value');

    $query = ContactMessage::query();

    /* 🔍 SEARCH */
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    /* 🏷 STATUS */
    if ($request->status) {
        $query->where('status', $request->status);
    }

    /* 📅 DATE FILTERS */

    // ✅ SINGLE DATE (highest priority)
    if ($request->single_date) {
        $query->whereDate('created_at', $request->single_date);
    }
    // ✅ RANGE DATE
    else {
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    }

    $totalRecords    = ContactMessage::count();
    $filteredRecords = $query->count();

    $records = $query
        ->orderBy('id', 'desc')
        ->skip($start)
        ->take($length)
        ->get();

    $data = [];
    $sr = $start + 1;

    foreach ($records as $row) {

        $data[] = [
            'sr'      => $sr++,
            'name'    => e($row->name),
            'email'   => e($row->email),
            'phone'   => e($row->phone),
            'message' => \Str::limit($row->message, 50),
            'status'  => $row->status === 'new'
                ? '<span class="badge bg-danger">New</span>'
                : '<span class="badge bg-secondary">Inactive</span>',
            'action'  => '
                <button class="btn btn-sm btn-info view-detail" data-id="'.$row->id.'">
                    <i class="mdi mdi-eye"></i>
                </button>
                <button class="btn btn-sm btn-success mark-inactive" data-id="'.$row->id.'">
                    <i class="mdi mdi-check"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">
                    <i class="mdi mdi-delete"></i>
                </button>
            ',
        ];
    }

    return response()->json([
        'draw'            => $draw,
        'recordsTotal'    => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data'            => $data,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $msg = ContactMessage::findOrFail($id);

    return response()->json([
        'name'    => $msg->name,
        'email'   => $msg->email,
        'phone'   => $msg->phone,
        'message' => $msg->message,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    ContactMessage::findOrFail($id)->delete();

    return response()->json(['status' => true]);
}


    public function markInactive($id)
{
    ContactMessage::where('id', $id)->update([
        'status' => 'inactive'
    ]);

    return response()->json(['status' => true]);
}

}
