<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class BuyEnquiryController extends Controller
{
public function index(Request $request)
{
    $type = $request->type;

    // Only Buy (1) or Sell (2) allowed
    if (!in_array($type, [1, 2])) {
        abort(404);
    }

    return view('admin.enquiries.buy.index', compact('type'));
}


public function data(Request $request)
{
    $columns = [
        0 => 'id',
        1 => 'name',
        2 => 'phone',
        3 => 'property_type',
        4 => 'sector',
        5 => 'status',
        6 => 'created_at',
    ];
$type = $request->type; // 1 or 2

    $totalRecords = Inquiry::where('type', $type)->count();

    $query = Inquiry::where('type', $type)->with('sectorData');

    // Search by phone
    if (!empty($request->phone)) {
        $query->where('phone', 'LIKE', "%{$request->phone}%");
    }

    // Filter by priority/status
    if (!empty($request->status)) {
        $query->where('status', $request->status);
    }

    $totalFiltered = $query->count();

    // Ordering
    $orderColumnIndex = $request->order[0]['column'];
    $orderColumn = $columns[$orderColumnIndex];
    $orderDirection = $request->order[0]['dir'];

    // Pagination
    $start = $request->start;
    $length = $request->length;

    $records = $query
        ->skip($start)
        ->take($length)
        ->orderBy($orderColumn, $orderDirection)
        ->get();

    // Make Data Array
    $data = [];
    foreach ($records as $index => $row) {
        $data[] = [
            'sr_no'         => $start + $index + 1,
            'name'          => $row->name,
            'phone'         => $row->phone,
            'property_type' => $row->property_type,
            'sector'        => $row->sectorData->name ?? 'N/A',
            'status'        => $row->status,
            'created_at'    => $row->created_at->format('d M Y'),

            'actions' => '
                <a href="'.route('inquiries.edit', $row->id).'" class="btn btn-sm btn-info">Edit</a>
                <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>
            ',
        ];
    }

    // 🔥 FINAL DATATABLE JSON RESPONSE
    return response()->json([
        'draw'            => intval($request->draw),
        'recordsTotal'    => $totalRecords,
        'recordsFiltered' => $totalFiltered,
        'data'            => $data
    ]);
}



  public function create(Request $request)
{
    $type = $request->type;   // 1 = Buy, 2 = Sell

    // Buy or Sell both allowed, otherwise 404
    if (!in_array($type, [1, 2])) {
        abort(404);
    }

    $sectors = \App\Models\Sector::orderBy('name')->get();
    $categories = \App\Models\Category::orderBy('name')->get();
    $subcategories = \App\Models\Subcategory::orderBy('name')->get();
    $inquiryStatus = config('constants.inquiry_status');

    return view('admin.enquiries.buy.create', compact(
        'type',
        'sectors',
        'categories',
        'subcategories',
        'inquiryStatus'
    ));
}



   public function store(Request $request)
{
    // VALIDATION
    $request->validate([
        'name'            => 'required|string|max:191',
        'phone'           => 'required|string|max:20',
        'email'           => 'nullable|email|max:191',
        
        'sector'          => 'required|integer',
        'category_id'     => 'required|integer',
        'subcategory_id'  => 'required|integer',
        
        'property_type'   => 'nullable|string|max:191',
        'message'         => 'nullable|string',
 'property_id' => 'nullable|integer|exists:properties,id',
        'status'          => 'required|integer',   // 1,2,3,4 (Urgent, High, Medium, Low)
    ]);

    // INSERT DATA
    $data = [
        'type'            =>  $request->type, // BUY = 1 (constant)
        'name'            => $request->name,
        'phone'           => $request->phone,
        'email'           => $request->email,
        'sector'          => $request->sector,
        'category_id'     => $request->category_id,
        'subcategory_id'  => $request->subcategory_id,
        'property_type'   => $request->property_type,
        'property_id' => $request->property_id,
        'message'         => $request->message,
        'status'          => $request->status,
    ];

    Inquiry::create($data);

return redirect()->route('inquiries.index', ['type' => $type])
    ->with('success', ' Inquiry Added Successfully');

}


    public function show($id)
    {
        // $enquiry = BuyEnquiry::findOrFail($id);
        // return view('admin.enquiries.buy.show', compact('enquiry'));
    }

 public function edit($id)
{
    $enquiry = Inquiry::findOrFail($id);
    $type = $enquiry->type;

    $sectors       = Sector::all();
    $categories    = Category::all();
    $subcategories = Subcategory::where('category_id', $enquiry->category_id)->get();

    $inquiryStatus = config('constants.inquiry_status'); // statuses list

    return view('admin.enquiries.buy.edit', compact(
        'enquiry',
        'sectors',
        'categories',
        'subcategories',
        'inquiryStatus',
        'type'
    ));
}


   public function update(Request $request, $id)
{
    $request->validate([
        'name'            => 'required|string|max:191',
        'phone'           => 'required|string|max:20',
        'email'           => 'nullable|email|max:191',

        'sector'          => 'required|integer',
        'category_id'     => 'required|integer',
        'subcategory_id'  => 'required|integer',

        'property_type'   => 'nullable|string|max:191',
         'property_id' => 'nullable|integer|exists:properties,id',

        'message'         => 'nullable|string',
        'status'          => 'required|integer', // priority
    ]);

    $enquiry = Inquiry::findOrFail($id);

    $enquiry->update([
        'name'            => $request->name,
        'phone'           => $request->phone,
        'email'           => $request->email,

        'sector'          => $request->sector,
        'category_id'     => $request->category_id,
        'subcategory_id'  => $request->subcategory_id,

        'property_type'   => $request->property_type,
        'property_id' => $request->property_id,

        'message'         => $request->message,
        'status'          => $request->status,   // priority update
    ]);

    return redirect()
        ->route('inquiries.index', ['type' => $request->type])
        ->with('success', 'Inquiry updated successfully!');
}


    public function destroy($id)
{
    $enquiry = Inquiry::findOrFail($id);
    $enquiry->delete();

    return response()->json([
        'success' => true,
        'message' => 'Inquiry deleted successfully.'
    ]);
}

}
