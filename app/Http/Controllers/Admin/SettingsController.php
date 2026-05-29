<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{
    /* =========================
       SHOW SETTINGS PAGE
    ========================= */
  public function index()
{
    // Always fetch single settings row
    $settings = Setting::first();
    $defaults = $this->defaults();

    return view('admin.settings.index', compact('settings', 'defaults'));
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

        'hero_title'        => 'nullable|string|max:255',
        'hero_subtitle'     => 'nullable|string|max:255',
        'hero_description'  => 'nullable|string',
        'hero_button_text'  => 'nullable|string|max:100',
        'hero_button_url'   => 'nullable|string|max:255',
        'hero_form_title'   => 'nullable|string|max:255',
        'hero_background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        'home_choose_title'      => 'nullable|string|max:255',
        'home_choose_subtitle'   => 'nullable|string|max:255',
        'home_stats_title'       => 'nullable|string|max:255',
        'home_stats_subtitle'    => 'nullable|string|max:255',

        'home_choose_items'               => 'nullable|array',
        'home_choose_items.*.icon'        => 'nullable|string|max:100',
        'home_choose_items.*.title'       => 'nullable|string|max:255',
        'home_choose_items.*.description' => 'nullable|string',

        'home_stats_items'           => 'nullable|array',
        'home_stats_items.*.value'    => 'nullable|string|max:255',
        'home_stats_items.*.label'    => 'nullable|string|max:255',
    ]);

    $settings = Setting::first();
    $data['home_choose_items'] = $this->normalizeItems($request->input('home_choose_items', []), [
        'icon',
        'title',
        'description',
    ]);
    $data['home_stats_items'] = $this->normalizeItems($request->input('home_stats_items', []), [
        'value',
        'label',
    ]);

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

    if ($request->hasFile('hero_background_image')) {
        if ($settings && $settings->hero_background_image && file_exists(public_path('uploads/settings/'.$settings->hero_background_image))) {
            unlink(public_path('uploads/settings/'.$settings->hero_background_image));
        }

        $background = $request->file('hero_background_image');
        $backgroundName = 'hero_bg_'.time().'.'.$background->getClientOriginalExtension();
        $background->move(public_path('uploads/settings'), $backgroundName);
        $data['hero_background_image'] = $backgroundName;
    }

    Setting::updateOrCreate(
        ['id' => 1],   // single row only
        $data
    );

    return redirect()
        ->back()
        ->with('success', 'Settings updated successfully.');
}

    private function normalizeItems(array $items, array $allowedKeys): array
    {
        return collect($items)
            ->map(function ($item) use ($allowedKeys) {
                return Arr::only(is_array($item) ? $item : [], $allowedKeys);
            })
            ->filter(function ($item) {
                return collect($item)->filter(fn ($value) => filled($value))->isNotEmpty();
            })
            ->values()
            ->all();
    }

    private function defaults(): array
    {
        return [
            'hero_title' => 'Safe & Reliable Vehicle Transportation Across India',
            'hero_subtitle' => 'Your Journey. Your Vehicle. Delivered.',
            'hero_description' => 'Laxis Cargo Movers provides professional vehicle transportation and cargo logistics services across India. We ensure safe handling, secure loading, timely delivery, and complete customer support throughout the transportation process.',
            'hero_button_text' => 'Request a Quote',
            'hero_button_url' => '#request-quote',
            'hero_form_title' => 'Request a Move',
            'home_choose_title' => 'Why Choose Us',
            'home_choose_subtitle' => 'Best Reasons',
            'home_stats_title' => 'Statistics',
            'home_stats_subtitle' => 'Our Numbers',
            'home_choose_items' => [
                ['icon' => 'flaticon-search', 'title' => 'Inspection', 'description' => 'Every vehicle undergoes a detailed inspection before pickup and before final delivery to ensure complete safety.'],
                ['icon' => 'flaticon-cash', 'title' => 'Secure Loading', 'description' => 'Vehicles are loaded using professional equipment and secured properly during transportation.'],
                ['icon' => 'flaticon-24-hours', 'title' => 'Live Tracking Support', 'description' => 'Get regular updates and tracking assistance throughout the transportation process.'],
                ['icon' => 'flaticon-fast-delivery', 'title' => 'On-Time Delivery', 'description' => 'We focus on timely pickup and delivery schedules to minimize delays.'],
                ['icon' => 'flaticon-insurance', 'title' => 'Fully Insured Transportation', 'description' => 'Additional protection options available for peace of mind during transit.'],
                ['icon' => 'flaticon-happy', 'title' => 'Customer Satisfaction', 'description' => 'Our support team remains available even after delivery to ensure a smooth experience.'],
            ],
            'home_stats_items' => [
                ['value' => '5000+', 'label' => 'Vehicles Delivered'],
                ['value' => '1000+', 'label' => 'Happy Customers'],
                ['value' => '25+', 'label' => 'States Covered'],
                ['value' => '99%', 'label' => 'Customer Satisfaction'],
            ],
        ];
    }

}
