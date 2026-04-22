<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the inbox for the authenticated user.
     */
    public function inbox()
    {
        $user = Auth::user();

        $messages = Message::where('receiver_id', $user->id)
            ->with(['sender', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('messages.inbox', compact('messages'));
    }

    /**
     * Display the sent messages for the authenticated user.
     */
    public function sent()
    {
        $user = Auth::user();

        $messages = Message::where('sender_id', $user->id)
            ->with(['receiver', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('messages.sent', compact('messages'));
    }

    /**
     * Show the form for creating a new message.
     */
    public function create(Request $request)
    {
        $receiverId = $request->get('receiver_id');
        $productId = $request->get('product_id');

        return view('messages.create', compact('receiverId', 'productId'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Prevent users from messaging themselves
        if ($request->receiver_id == Auth::id()) {
            return back()->withErrors(['receiver_id' => 'You cannot send messages to yourself.']);
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'product_id' => $request->product_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.inbox')->with('success', 'Message sent successfully!');
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Check if user can view this message
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if receiver is viewing
        if ($message->receiver_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('messages.show', compact('message'));
    }

    /**
     * Mark message as read.
     */
    public function markAsRead(Message $message)
    {
        if ($message->receiver_id === Auth::id()) {
            $message->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get unread message count for the authenticated user.
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
