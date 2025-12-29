<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarRate;
use App\Models\State;
use App\Models\CarType;
use App\Models\CarMoveRequest;
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

    $query = CarRate::query();

    $query->where('pickup_state_id', $request->pickup_state)
          ->where('drop_state_id', $request->drop_state)
          ->where('car_type_id', $request->car_type);

    // Price range filter
    if ($request->price_range) {
        $range = explode('-', str_replace(',', '', $request->price_range));
        if (count($range) == 2) {
            $min = floatval(trim($range[0]));
            $max = floatval(trim($range[1]));
            $query->whereBetween('price', [$min, $max]);
        }
    }

    $rates = $query->with(['pickupState', 'dropState', 'carType'])->get();

    // Append readable names
    $rates->transform(function($item){
        $item->pickup_state_name = $item->pickupState->name ?? '';
        $item->drop_state_name = $item->dropState->name ?? '';
        $item->car_type_name = $item->carType->name ?? '';
        return $item;
    });

    // Return JSON for AJAX
    return response()->json($rates);
    }

  public function requestMove(Request $request)
{
    // ✅ VALIDATION (exact request data ke according)
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|max:255',
        'contact_no'      => 'required|string|max:20',
        'pickup_location' => 'required|string|max:255',
        'drop_location'   => 'required|string|max:255',
    ]);

    // ✅ SAVE TO DATABASE
    CarMoveRequest::create([
        'name'            => $request->name,
        'email'           => $request->email,
        'contact_no'      => $request->contact_no,
        'pickup_location' => $request->pickup_location,
        'drop_location'   => $request->drop_location,
    ]);

    // ✅ AJAX RESPONSE
    return response()->json([
        'status'  => true,
        'message' => 'Request submitted successfully'
    ]);
}



}
