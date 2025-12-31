<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    /* =========================
       SHOW SETTINGS PAGE
    ========================= */
  public function index()
{
    // Always fetch single settings row
    $settings = Setting::first();

    return view('admin.settings.index', compact('settings'));
}

    /* =========================
       SAVE / UPDATE SETTINGS
    ========================= */
   public function store(Request $request)
{
    $data = $request->validate([
        'site_name'   => 'required|string|max:255',
        'phone'       => 'nullable|string|max:20',
        'email'       => 'nullable|email|max:255',
        'address'     => 'nullable|string',
        'footer_text' => 'nullable|string',
        'google_map'  => 'nullable|string',

        'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'favicon'     => 'nullable|image|mimes:jpg,jpeg,png,ico,webp|max:1024',
    ]);

    $settings = Setting::first();

    /* ===== LOGO UPLOAD ===== */
    if ($request->hasFile('logo')) {

        if ($settings && $settings->logo && file_exists(public_path('uploads/settings/'.$settings->logo))) {
            unlink(public_path('uploads/settings/'.$settings->logo));
        }

        $logo = $request->file('logo');
        $logoName = 'logo_'.time().'.'.$logo->getClientOriginalExtension();
        $logo->move(public_path('uploads/settings'), $logoName);
        $data['logo'] = $logoName;
    }

    /* ===== FAVICON UPLOAD ===== */
    if ($request->hasFile('favicon')) {

        if ($settings && $settings->favicon && file_exists(public_path('uploads/settings/'.$settings->favicon))) {
            unlink(public_path('uploads/settings/'.$settings->favicon));
        }

        $favicon = $request->file('favicon');
        $faviconName = 'favicon_'.time().'.'.$favicon->getClientOriginalExtension();
        $favicon->move(public_path('uploads/settings'), $faviconName);
        $data['favicon'] = $faviconName;
    }

    Setting::updateOrCreate(
        ['id' => 1],   // single row only
        $data
    );

    return redirect()
        ->back()
        ->with('success', 'Settings updated successfully.');
}

}
