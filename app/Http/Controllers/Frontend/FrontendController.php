<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarRate;
use App\Models\State;
use App\Models\CarType;
use App\Models\CarMoveRequest;
use App\Models\ContactMessage;
class FrontendController extends Controller
{
    public function index(Request $request)
{
    $request->validate([
        'pickup_state' => 'required|exists:states,id',
        'drop_state'   => 'required|exists:states,id',
        'car_type'     => 'required|exists:car_types,id',
        'price_range'  => 'nullable|string',
    ]);

    $query = CarRate::with(['pickupState', 'dropState', 'carType'])
        ->where('pickup_state_id', $request->pickup_state)
        ->where('drop_state_id', $request->drop_state)
        ->where('car_type_id', $request->car_type);

    // Price range
    if ($request->filled('price_range')) {
        $range = explode('-', str_replace(',', '', $request->price_range));

        if (count($range) === 2) {
            $query->whereBetween('price', [
                (float) trim($range[0]),
                (float) trim($range[1])
            ]);
        }
    }

    $rates = $query->get()->map(function ($item) {
        return [
            'pickup_state_name' => $item->pickupState->name ?? '-',
            'drop_state_name'   => $item->dropState->name ?? '-',
            'car_type_name'     => $item->carType->name ?? '-',
            'price'             => $item->price,
        ];
    });

    return response()->json($rates);
}


public function requestMove(Request $request)
{
    // ✅ VALIDATION
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|max:255',
        'contact_no'      => 'required|string|max:20',
        'pickup_location' => 'required|string|max:255',
        'drop_location'   => 'required|string|max:255',
        'pickup_state_id' => 'required|exists:states,id',
        'drop_state_id'   => 'required|exists:states,id',
        'car_type_id'     => 'required|exists:car_types,id',
        'price_range'     => 'nullable|string|max:50',
    ]);

    // ✅ SAVE TO DATABASE (status = new)
    CarMoveRequest::create([
        'name'            => $request->name,
        'email'           => $request->email,
        'contact_no'      => $request->contact_no,
        'pickup_location' => $request->pickup_location,
        'drop_location'   => $request->drop_location,
        'pickup_state_id' => $request->pickup_state_id,
        'drop_state_id'   => $request->drop_state_id,
        'car_type_id'     => $request->car_type_id,
        'price_range'     => $request->price_range,
        'status'          => 'new', // 🔥 DEFAULT STATUS
    ]);

    // ✅ AJAX RESPONSE
    return response()->json([
        'status'  => true,
        'message' => 'Car move request submitted successfully'
    ]);
}

 public function submit(Request $request)
    {
        // 🔒 Validation
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'message' => 'required|string|min:5',
        ]);

        // 💾 SAVE TO DATABASE
        ContactMessage::create($validated);

        // ✅ AJAX RESPONSE
        return response()->json([
            'status'  => true,
            'message' => 'Thank you! Your message has been sent successfully.'
        ]);
    }


}
