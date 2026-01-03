<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\SmsHistory;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\Log;
use App\Models\Sector;
use App\Models\Category;

class WhatsappMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.whatsapp', [
            'sectors'   => Sector::all(),
            'categories' => Category::all(),
        ]);; 
        // yahan tera WhatsApp form load hoga (same SMS form copy kar sakta hai)
    }

public function send(Request $request)
{
    /*
    |------------------------------------------------------
    | VALIDATION (SAFE & CONDITIONAL)
    |------------------------------------------------------
    */
    $rules = [
        'message' => 'required|string|min:1',
        'send_type' => 'required|in:phone,property',
    ];

    if ($request->send_type === 'phone') {
        $rules['phone_numbers'] = 'required|string|min:10';
    }

    $request->validate($rules);

    $message  = $request->message;
    $whatsapp = new WhatsappService();

    $sentCount   = 0;
    $failedCount = 0;

    /*
    |------------------------------------------------------
    | MODE 1 : SEND BY PHONE NUMBERS
    |------------------------------------------------------
    */
    if ($request->send_type === 'phone') {

        $numbers = preg_split('/[\s,]+/', $request->phone_numbers);
        $numbers = array_unique(array_filter($numbers));

        foreach ($numbers as $mobile) {

            $mobile = preg_replace('/\D/', '', $mobile);

            if (strlen($mobile) === 10) {
                $mobile = '91' . $mobile;
            }

            if (strlen($mobile) !== 12 || substr($mobile, 0, 2) !== '91') {
                SmsHistory::create([
                    'property_id' => null,
                    'mobile' => $mobile,
                    'type' => 'whatsapp',
                    'message' => $message,
                    'status' => 'failed',
                    'api_response' => 'Invalid mobile format',
                ]);
                $failedCount++;
                continue;
            }

            try {
                $success = $whatsapp->sendText($mobile, $message);

                SmsHistory::create([
                    'property_id' => null,
                    'mobile' => $mobile,
                    'type' => 'whatsapp',
                    'message' => $message,
                    'status' => $success ? 'sent' : 'failed',
                    'api_response' => $success ? 'OK' : 'Unknown WhatsApp failure',
                ]);

                $success ? $sentCount++ : $failedCount++;

            } catch (\Exception $e) {

                SmsHistory::create([
                    'property_id' => null,
                    'mobile' => $mobile,
                    'type' => 'whatsapp',
                    'message' => $message,
                    'status' => 'failed',
                    'api_response' => $e->getMessage(),
                ]);
                $failedCount++;
            }
        }

        return back()->with(
            'success',
            "WhatsApp sent by phone. Sent: {$sentCount}, Failed: {$failedCount}"
        );
    }

    /*
    |------------------------------------------------------
    | MODE 2 : SEND BY PROPERTY FILTER
    |------------------------------------------------------
    */
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

    if ($request->property_id && is_array($request->property_id)) {
        $query->whereIn('id', $request->property_id);
    }

    $properties = $query->get();

    foreach ($properties as $property) {

        $mobile = preg_replace('/\D/', '', $property->contact_number);

        if (strlen($mobile) === 10) {
            $mobile = '91' . $mobile;
        }

        if (strlen($mobile) !== 12 || substr($mobile, 0, 2) !== '91') {
            SmsHistory::create([
                'property_id' => $property->id,
                'mobile' => $mobile,
                'type' => 'whatsapp',
                'message' => $message,
                'status' => 'failed',
                'api_response' => 'Invalid mobile format',
            ]);
            $failedCount++;
            continue;
        }

        try {
            $success = $whatsapp->sendText($mobile, $message);

            SmsHistory::create([
                'property_id' => $property->id,
                'mobile' => $mobile,
                'type' => 'whatsapp',
                'message' => $message,
                'status' => $success ? 'sent' : 'failed',
                'api_response' => $success ? 'OK' : 'Unknown WhatsApp failure',
            ]);

            $success ? $sentCount++ : $failedCount++;

        } catch (\Exception $e) {

            SmsHistory::create([
                'property_id' => $property->id,
                'mobile' => $mobile,
                'type' => 'whatsapp',
                'message' => $message,
                'status' => 'failed',
                'api_response' => $e->getMessage(),
            ]);
            $failedCount++;
        }
    }

    return back()->with(
        'success',
        "WhatsApp sent by property. Sent: {$sentCount}, Failed: {$failedCount}"
    );
}


}
