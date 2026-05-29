<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        return view('admin.settings.general.index');
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
    // TEXT SETTINGS
    $settings = [
        'site_name',
        'email',
    ];

    foreach ($settings as $key) {
        \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $request->$key]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGO UPLOAD (public/uploads/settings)
    |--------------------------------------------------------------------------
    */
    if ($request->hasFile('site_logo')) {

        $logo = $request->file('site_logo');
        $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();

        $logo->move(public_path('uploads/settings'), $logoName);

        \App\Models\Setting::updateOrCreate(['id' => 1], ['logo' => $logoName]);
    }

    /*
    |--------------------------------------------------------------------------
    | FAVICON UPLOAD (public/uploads/settings)
    |--------------------------------------------------------------------------
    */
    if ($request->hasFile('site_favicon')) {

        $favicon = $request->file('site_favicon');
        $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();

        $favicon->move(public_path('uploads/settings'), $faviconName);

        \App\Models\Setting::updateOrCreate(['id' => 1], ['favicon' => $faviconName]);
    }

    return back()->with('success', 'Settings updated successfully');
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
