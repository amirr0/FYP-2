<?php

namespace App\Http\Controllers\Frontend;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontendChatController extends Controller
{

    public function index(Request $request)
    {
        $guestId = $request->guest_id;
        $messages = ChatMessage::where('guest_id', $guestId)->orderBy('created_at')->get();

        return (['messages' => $messages]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'guest_id' => 'required|string|max:255'
        ]);

        $message = new ChatMessage();
        $message->guest_id = $request->guest_id;
        $message->message = $request->message;
        $message->message_type = 'sent';
        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 200);
    }

    public function markRead(Request $request)
    {
        $guestId = $request->guest_id;

        ChatMessage::where('guest_id', $guestId)
            ->where('message_type', 'received')
            ->update(['read' => true]);

        return response()->json(['message' => 'Messages marked as read'], 200);
    }
}
