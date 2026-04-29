<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Notifications\NewChatNotification;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::with('messages')->orderBy('last_message_at', 'desc')->get();

        return response()->json($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $visitorId = $request->visitor_id;

        $chat = Chat::create([
            'visitor_id' => $visitorId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'active',
            'last_message_at' => now(),
        ]);

        $message = $chat->messages()->create([
            'sender_type' => 'visitor',
            'message' => $request->message,
        ]);

        // Notify admins
        $admins = User::role('Admin')->get();
        Notification::send($admins, new NewChatNotification($chat));

        return response()->json(['chat_id' => $chat->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = Chat::findOrFail($id);
        $messages = $chat->messages()->orderBy('created_at')->get();

        return response()->json($messages);
    }

    /**
     * Get messages for a specific chat.
     */
    public function getMessages(Chat $chat)
    {
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'message' => 'required|string',
            'sender_type' => 'required|in:visitor,admin',
        ]);

        $chat = Chat::findOrFail($id);
        $message = $chat->messages()->create([
            'sender_type' => $request->sender_type,
            'message' => $request->message,
        ]);

        $chat->update(['last_message_at' => now()]);

        // Notify admins if visitor sent message
        if ($request->sender_type === 'visitor') {
            $admins = User::role('Admin')->get();
            Notification::send($admins, new NewMessageNotification($message));
        }

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chat = Chat::findOrFail($id);
        $chat->update(['status' => 'closed']);

        return response()->json(['message' => 'Chat closed']);
    }

    /**
     * Admin index for chats.
     */
    public function adminIndex()
    {
        $chats = Chat::with('messages')->orderBy('last_message_at', 'desc')->paginate(20);

        return view('admin.chats.index', compact('chats'));
    }

    /**
     * Admin show chat.
     */
    public function adminShow(Chat $chat)
    {
        $chat->load('messages');

        return view('admin.chats.show', compact('chat'));
    }

    /**
     * Admin reply to chat.
     */
    public function adminReply(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat->messages()->create([
            'sender_type' => 'admin',
            'message' => $request->message,
        ]);

        // Mark all customer messages as read
        $chat->messages()->where('sender_type', '!=', 'admin')->whereNull('read_at')->update(['read_at' => now()]);

        $chat->update(['last_message_at' => now()]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Set typing status.
     */
    public function setTyping(Request $request, Chat $chat)
    {
        $request->validate([
            'is_typing' => 'required|boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $chat->update([
            'typing_user_id' => $request->is_typing ? ($request->user_id ?: 'visitor') : null,
            'typing_at' => $request->is_typing ? now() : null,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get typing status.
     */
    public function getTyping(Chat $chat)
    {
        $isTyping = false;
        $typingUser = null;

        if ($chat->typing_user_id && $chat->typing_at && $chat->typing_at->gt(now()->subSeconds(5))) {
            $isTyping = true;
            if ($chat->typing_user_id === 'visitor') {
                $typingUser = [
                    'id' => 'visitor',
                    'name' => $chat->name ?: 'Visitor',
                ];
            } else {
                $typingUser = User::find($chat->typing_user_id);
                if ($typingUser) {
                    $typingUser = [
                        'id' => $typingUser->id,
                        'name' => $typingUser->name,
                    ];
                }
            }
        }

        return response()->json([
            'is_typing' => $isTyping,
            'typing_user' => $typingUser,
        ]);
    }

    /**
     * Upload file attachment.
     */
    public function uploadFile(Request $request, Chat $chat)
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt',
        ]);

        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('chat-files', $filename, 'public');

        $message = $chat->messages()->create([
            'sender_type' => $request->user()->hasRole('Admin') ? 'admin' : 'seller',
            'message' => $path,
            'message_type' => 'file',
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_mime' => $file->getMimeType(),
        ]);

        $chat->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $path,
                'message_type' => 'file',
                'file_name' => $file->getClientOriginalName(),
                'created_at' => $message->created_at->toIsoString(),
            ],
        ]);
    }

    /**
     * Visitor store - create new chat from public form.
     */
    public function visitorStore(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        $visitorId = $request->visitor_id;

        $chat = Chat::create([
            'visitor_id' => $visitorId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'active',
            'last_message_at' => now(),
        ]);

        $message = $chat->messages()->create([
            'sender_type' => 'visitor',
            'message' => $request->message,
        ]);

        // Notify admins
        $admins = User::role('Admin')->get();
        Notification::send($admins, new NewChatNotification($chat));

        return response()->json(['chat_id' => $chat->id]);
    }

    /**
     * Visitor get messages.
     */
    public function visitorMessages(Chat $chat)
    {
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    /**
     * Visitor send message.
     */
    public function visitorUpdate(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
            'sender_type' => 'required|in:visitor,admin',
        ]);

        $message = $chat->messages()->create([
            'sender_type' => $request->sender_type,
            'message' => $request->message,
        ]);

        $chat->update(['last_message_at' => now()]);

        // Notify admins if visitor sent message
        if ($request->sender_type === 'visitor') {
            $admins = User::role('Admin')->get();
            Notification::send($admins, new NewMessageNotification($message));
        }

        return response()->json($message);
    }

    /**
     * Visitor send message - public endpoint.
     */
    public function visitorSendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $chat->messages()->create([
            'sender_type' => 'visitor',
            'message' => $request->message,
        ]);

        $chat->update(['last_message_at' => now()]);

        // Notify admins
        $admins = User::role('Admin')->get();
        Notification::send($admins, new NewMessageNotification($message));

        return response()->json($message);
    }

    /**
     * Visitor show chat details.
     */
    public function visitorShow(Chat $chat)
    {
        return response()->json([
            'chat' => $chat,
        ]);
    }

    /**
     * Delete a message.
     */
    public function destroyMessage(Request $request, Chat $chat, $messageId)
    {
        $message = $chat->messages()->findOrFail($messageId);

        // Check if user owns the message
        $isOwner = false;
        if ($request->user()->hasRole('Admin') && $message->sender_type === 'admin') {
            $isOwner = true;
        } elseif (! $request->user()->hasRole('Admin') && $message->sender_type === 'seller') {
            $isOwner = true;
        } elseif ($message->user_id === $request->user()->id) {
            $isOwner = true;
        }

        if (! $isOwner) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        return response()->json(['success' => true, 'message_id' => $messageId]);
    }
}
