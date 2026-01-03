<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use App\Models\Category;
use App\Models\Subcategory;

class SettingsController extends Controller
{
    public function manage($type)
    {
        switch ($type) {
            case 'sector':
                $title = "Manage Sectors";
                $items = Sector::all();
                break;

            case 'category':
                $title = "Manage Categories";
                $items = Category::all();
                break;

            case 'subcategory':
                $title = "Manage Subcategories";
                $items = Subcategory::with('category')->get();
                break;

            default:
                abort(404);
        }

        return view('admin.settings.manage', compact('type', 'items', 'title'));
    }


    public function save(Request $request, $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
        ]);

        switch ($type) {

            // ----------------------
            // SECTOR LOGIC
            // ----------------------
            case 'sector':
                Sector::firstOrCreate(
                    ['name' => trim($request->name)],
                    ['code' => trim($request->name)]
                );
                break;

            // ----------------------
            // CATEGORY LOGIC
            // ----------------------
            case 'category':
                Category::firstOrCreate(
                    ['name' => trim($request->name)],
                    ['code' => trim($request->name)]
                );
                break;

            // ----------------------
            // SUBCATEGORY LOGIC
            // ----------------------
            case 'subcategory':
                Subcategory::firstOrCreate(
                    ['name' => trim($request->name)],
                    [
                        'code' => trim($request->name),
                        'category_id' => $request->category_id ?? null
                    ]
                );
                break;

            default:
                abort(404);
        }

        return back()->with('success', ucfirst($type) . ' added successfully!');
    }
}
