<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarMoveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarMoveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return view('admin.car-move-requests.index');
}


    public function ajax(Request $request)
{
    $query = CarMoveRequest::query();

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->single_date) {
        $query->whereDate('created_at', $request->single_date);
    } else {
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    }

    $total = $query->count();
    $start = $request->start ?? 0;
    $length = $request->length ?? 10;

    $rows = $query->orderBy('id','desc')->skip($start)->take($length)->get();

    $data = [];
    $sr = $start + 1;

    foreach ($rows as $r) {
        $data[] = [
            'sr' => $sr++,
            'name' => e($r->name),
            'email' => e($r->email),
            'contact_no' => e($r->contact_no),
            'pickup_location' => e($r->pickup_location),
            'drop_location' => e($r->drop_location),
            'status' => '<span class="badge bg-'.($r->status=='new'?'danger':'secondary').'">'.ucfirst($r->status).'</span>',
            'action' => '
                <button class="btn btn-sm btn-info view-btn" data-id="'.$r->id.'">View</button>
                <button class="btn btn-sm btn-success change-status" data-id="'.$r->id.'" data-status="processing">Processing</button>
                <button class="btn btn-sm btn-primary change-status" data-id="'.$r->id.'" data-status="completed">Completed</button>
                <button class="btn btn-sm btn-danger change-status" data-id="'.$r->id.'" data-status="cancelled">Cancel</button>
            '
        ];
    }

    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => CarMoveRequest::count(),
        'recordsFiltered' => $total,
        'data' => $data
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
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
