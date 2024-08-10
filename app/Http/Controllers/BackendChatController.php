<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackendChatController extends Controller
{

    public function index()
    {
        return view('modules.chats.index');
    }
    public function listGuests()
    {
        $guests = ChatMessage::select('guest_id', DB::raw('MAX(message) as last_message'), DB::raw('MAX(created_at) as last_message_time'))
            ->groupBy('guest_id')
            ->get();

            foreach ($guests as &$guest) {
                $guest['created_at_human'] = Carbon::parse($guest['last_message_time'])->diffForHumans();
            }

        return response()->json(['guests' => $guests]);
    }

    public function getMessagesForAdmin(Request $request)
    {
        $guestId = $request->guest_id;
        $messages = ChatMessage::where('guest_id', $guestId)->orderBy('created_at')->get();

        // Convert the created_at to a human-readable format
        $messages->transform(function ($message) {
            $message->created_at_human = Carbon::parse($message->created_at)->diffForHumans();
            return $message;
        });

        return response()->json(['messages' => $messages]);
    }
    public function storeMessageFromAdmin(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'guest_id' => 'required|string|max:255'
        ]);

        $message = new ChatMessage();
        $message->guest_id = $request->guest_id;
        $message->message = $request->message;
        $message->message_type = 'received';
        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }
}
