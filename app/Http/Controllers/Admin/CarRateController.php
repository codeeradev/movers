<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarRate;
use App\Models\State;
use App\Models\CarType;

class CarRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    // Eager load related states and car type
    $rates = \App\Models\CarRate::with(['pickupState', 'dropState', 'carType'])
                ->orderBy('id', 'desc')
                ->get();

    return view('admin.price.index', compact('rates'));
}


    /**
     * Show the form for creating a new resource.
     */


public function create()
{
    // All states get kar ke pass karenge form me
    $states = State::orderBy('name')->get();

    // All car types
    $carTypes = CarType::where('status', 1)->orderBy('name')->get();

    return view('admin.price.create', compact('states', 'carTypes'));
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $request->validate([
        'pickup_state' => 'required|exists:states,id',
        'drop_state' => 'required|exists:states,id',
        'car_type' => 'required|exists:car_types,id',
        'price' => 'required|string|max:50',
        'status' => 'required|in:0,1',
    ]);

    CarRate::create([
        'pickup_state_id' => $request->pickup_state,
        'drop_state_id' => $request->drop_state,
        'car_type_id' => $request->car_type,
        'price' => $request->price,
        'status' => $request->status,
    ]);

    return redirect()->route('price-list.index')->with('success', 'Price added successfully.');
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
