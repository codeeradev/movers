<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\ScheduledMessage;
use App\Models\Sector;
use App\Models\Category;

use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    public function index()
    {
        return view('admin.messages.index', [
            'sectors'   => Sector::all(),
            'categories' => Category::all(),
        ]);
    }

     public function send(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'sector_id'   => 'required',
            'message'     => 'required',
        ]);

        $clients = Property::where('category_id', $request->category_id)
                    ->where('sector_id', $request->sector_id)
                    ->get();

                  
        foreach ($clients as $client) {
            // Add Your SMS API Here
            // sendSMS($client->phone, $request->message);
        }

        return back()->with('success', 'Message sent to all matched clients!');
    }
    // Store admin message
   public function store(Request $request)
{
    // Base validation rules
    $rules = [
        'title' => 'required|string|max:255',
        'message_template' => 'required|string',
        'type' => 'required|in:birthday,festival',
    ];

    // Only require event_date if type == festival
    if ($request->type === 'festival') {
        $rules['event_date'] = 'required|date';
    }

    $validated = $request->validate($rules);

    // If type is birthday, explicitly set event_date = null
    if ($request->type === 'birthday') {
        $validated['event_date'] = null;
    }

    // Save to DB
    ScheduledMessage::create([
        'title' => $validated['title'],
        'message_template' => $validated['message_template'],
        'event_date' => $validated['event_date'], // can be null
        'type' => $validated['type'],
        'status' => 1,
    ]);

    return back()->with('success', 'Message scheduled successfully!');
}

    // Automatically send messages based on today's date
    public function sendMessages()
    {
        $today = now()->format('Y-m-d');
        $messages = ScheduledMessage::whereDate('event_date', $today)
            ->where('status', 1)
            ->get();

        foreach ($messages as $msg) {
            // Fetch users based on message type
            if ($msg->type === 'birthday') {
                $users = Property::whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [now()->format('m-d')])->get();
            } else {
                $users = Property::all();
            }

            if ($users->isEmpty()) continue;

            foreach ($users as $user) {
                $personalized = str_replace('{name}', $user->owner_name, $msg->message_template);

                // Example Email Send (can replace with SMS)
                if ($user->email) {
                    Mail::raw($personalized, function ($mail) use ($user, $msg) {
                        $mail->to($user->email)
                             ->subject($msg->title);
                    });
                }
            }
        }

        return response()->json(['message' => 'Messages sent successfully for today']);
    }
}
