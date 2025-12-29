<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    // List all car types
    public function index()
    {
        $carTypes = CarType::orderBy('name')->get();
        return view('admin.car-types.index', compact('carTypes'));
    }

    // Show create form
    public function create()
    {
        return view('admin.car-types.create');
    }

    // Store new car type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        CarType::create($request->only('name', 'status'));

        return redirect()->route('car-types.index')
                         ->with('success', 'Car type added successfully.');
    }

    // Show edit form
    public function edit(CarType $carType)
    {
        return view('admin.car-types.edit', compact('carType'));
    }

    // Update car type
    public function update(Request $request, CarType $carType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $carType->update($request->only('name', 'status'));

        return redirect()->route('car-types.index')
                         ->with('success', 'Car type updated successfully.');
    }

    // Delete car type
    public function destroy(CarType $carType)
    {
        $carType->delete();

        return redirect()->route('car-types.index')
                         ->with('success', 'Car type deleted successfully.');
    }
}
