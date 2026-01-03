<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\Property;
use App\Models\SmsHistory;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
   public function sendSms(Request $request)
{
    // Log start
    Log::info('SMS Send Request Started', $request->all());

    $sms = new SmsService();
    $message = "For sale or purchase of property in any HUDA sector Hisar, please contact Raj Associates, SSB-57P-58 Sector 13P Hisar. Call: 9254220220, 9255406621.";
    $template_id = "186157";

    $sentCount = 0;
    $failedCount = 0;

    /*
    |--------------------------------------------------------------------------
    | MODE 1: SEND BY PHONE NUMBER
    |--------------------------------------------------------------------------
    */
    if ($request->send_type === 'phone') {

        // numbers split (comma / space / newline)
        $numbers = preg_split('/[\s,]+/', $request->phone_numbers);

        // clean & unique
        $numbers = array_unique(array_filter($numbers));

        if (count($numbers) === 0) {
            return back()->with('error', 'No phone numbers provided');
        }

        foreach ($numbers as $mobile) {
            try {
                $apiResponse = $sms->send($mobile, $message, $template_id);

                SmsHistory::create([
                         'type' => 'sms',
                    'property_id'  => null,
                    'mobile'       => $mobile,
                    'message'      => $message,
                    'template_id'  => $template_id,
                    'status'       => 'sent',
                    'api_response' => json_encode($apiResponse),
                ]);

                $sentCount++;

            } catch (\Exception $e) {

                SmsHistory::create([
                         'type' => 'sms',
                    'property_id'  => null,
                    'mobile'       => $mobile,
                    'message'      => $message,
                    'template_id'  => $template_id,
                    'status'       => 'failed',
                    'api_response' => $e->getMessage(),
                ]);

                $failedCount++;
            }
        }

        return redirect()->back()->with(
            'success',
            "SMS sent by phone numbers. Sent: {$sentCount}, Failed: {$failedCount}"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MODE 2: SEND BY PROPERTY (OLD LOGIC – UNCHANGED)
    |--------------------------------------------------------------------------
    */

    $propertyIds = $request->property_id;

    $query = Property::query();

    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->subcategory_id) {
        $query->where('subcategory_id', $request->subcategory_id);
    }

    if ($request->sector_id) {
        $query->where('sector_id', $request->sector_id);
    }

    if ($propertyIds && count($propertyIds) > 0) {
        $query->whereIn('id', $propertyIds);
    }

    $properties = $query->get();

    if ($properties->count() === 0) {
        return back()->with('error', 'No matching properties found');
    }

    foreach ($properties as $property) {

        $mobile = $property->contact_number;

        if (!$mobile) {
            continue;
        }

        try {
            $apiResponse = $sms->send($mobile, $message, $template_id);

            SmsHistory::create([
                     'type' => 'sms',
                'property_id'  => $property->id,
                'mobile'       => $mobile,
                'message'      => $message,
                'template_id'  => $template_id,
                'status'       => 'sent',
                'api_response' => json_encode($apiResponse),
            ]);

            $sentCount++;

        } catch (\Exception $e) {

            SmsHistory::create([
                     'type' => 'sms',
                'property_id'  => $property->id,
                'mobile'       => $mobile,
                'message'      => $message,
                'template_id'  => $template_id,
                'status'       => 'failed',
                'api_response' => $e->getMessage(),
            ]);

            $failedCount++;
        }
    }

    return redirect()->back()->with(
        'success',
        "SMS sent by property. Sent: {$sentCount}, Failed: {$failedCount}"
    );
}


    public function history()
{
    return view('admin.messages.history');
}

public function historyData(Request $request)
{
    $histories = SmsHistory::with('property')
        ->orderBy('id', 'desc')
        ->get();

    $data = [];

    foreach ($histories as $row) {

        $property = $row->property;

        $data[] = [
            'id' => $row->id,
            'owner_name' => $property->owner_name ?? '-',
            'property_number' => $property->property_number ?? '-',
            'address' => $property->address ?? '-',
            'location' => $property->location ?? '-',
            'mobile' => $row->mobile,
                 'type' => $row->type,
            'status' => ucfirst($row->status),
            'created_at' => $row->created_at->format('d-m-Y H:i'),
        ];
    }

    return response()->json([
        'data' => $data
    ]);
}
}
