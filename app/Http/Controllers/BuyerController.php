<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Product;
use App\Models\Rental;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display buyer dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Exchange statistics
        $receivedExchangesQuery = $user->receivedExchanges();
        $proposedExchangesQuery = $user->proposedExchanges();

        $totalReceivedExchanges = $receivedExchangesQuery->count();
        $pendingExchangesCount = $receivedExchangesQuery->where('status', 'pending')->count();
        $acceptedExchangesCount = $receivedExchangesQuery->where('status', 'accepted')->count();
        $completedExchangesCount = $receivedExchangesQuery->where('status', 'completed')->count();
        $rejectedExchangesCount = $receivedExchangesQuery->where('status', 'rejected')->count();

        $totalSentExchanges = $proposedExchangesQuery->count();

        // Rental statistics
        $rentalsQuery = $user->rentals();
        $totalRentals = $rentalsQuery->count();
        $activeRentalsCount = $rentalsQuery->whereIn('status', ['approved', 'active'])->count();
        $pendingRentalsCount = $rentalsQuery->where('status', 'pending')->count();
        $completedRentalsCount = $rentalsQuery->where('status', 'completed')->count();

        // Recent data
        $recentReceivedExchanges = $receivedExchangesQuery
            ->with(['proposer', 'offeredProduct', 'requestedProduct'])
            ->latest()
            ->take(5)
            ->get();

        $recentSentExchanges = $proposedExchangesQuery
            ->with(['offeredProduct', 'requestedProduct'])
            ->latest()
            ->take(5)
            ->get();

        $recentRentals = $rentalsQuery
            ->with(['product', 'product.user'])
            ->latest()
            ->take(5)
            ->get();

        // Recent products browsed (favorites/wishlist - simplified as products user has interacted with)
        $browsedProducts = $user->products()->count();

        // Messages count
        $unreadMessagesCount = $user->receivedMessages()->where('is_read', false)->count();

        // User location
        $userLocation = $user->location ?? 'Not specified';

        return view('buyer.dashboard', compact(
            'totalReceivedExchanges',
            'pendingExchangesCount',
            'acceptedExchangesCount',
            'completedExchangesCount',
            'rejectedExchangesCount',
            'totalSentExchanges',
            'totalRentals',
            'activeRentalsCount',
            'pendingRentalsCount',
            'completedRentalsCount',
            'recentReceivedExchanges',
            'recentSentExchanges',
            'recentRentals',
            'browsedProducts',
            'unreadMessagesCount',
            'userLocation'
        ));
    }

    /**
     * Display a listing of exchanges.
     */
    public function exchangesIndex()
    {
        $user = Auth::user();

        $exchanges = $user->receivedExchanges()
            ->with(['proposer', 'offeredProduct.category', 'requestedProduct.category'])
            ->latest()
            ->paginate(10);

        return view('buyer.exchanges.index', compact('exchanges'));
    }

    /**
     * Show the form for creating a new exchange.
     */
    public function exchangesCreate(Request $request)
    {
        $user = Auth::user();

        // Get the product they want to request
        $requestedProductId = $request->get('product_id');
        $requestedProduct = null;

        if ($requestedProductId) {
            $requestedProduct = Product::where('id', $requestedProductId)
                ->where('status', 'active')
                ->firstOrFail();
        }

        // Get user's active products for offering
        $userProducts = $user->products()->where('status', 'active')->get();

        return view('buyer.exchanges.create', compact('userProducts', 'requestedProduct'));
    }

    /**
     * Store a newly created exchange.
     */
    public function exchangesStore(Request $request)
    {
        $request->validate([
            'offered_product_id' => 'required|exists:products,id',
            'requested_product_id' => 'required|exists:products,id|different:offered_product_id',
        ]);

        $user = Auth::user();
        $offeredProduct = Product::findOrFail($request->offered_product_id);
        $requestedProduct = Product::findOrFail($request->requested_product_id);

        // Ensure offered product belongs to user
        if ($offeredProduct->user_id !== $user->id) {
            return back()->withErrors(['offered_product_id' => 'You can only offer your own products.']);
        }

        // Ensure requested product is active
        if ($requestedProduct->status !== 'active') {
            return back()->withErrors(['requested_product_id' => 'The requested product is not available.']);
        }

        // Check if exchange already exists
        $existingExchange = Exchange::where('proposer_id', $user->id)
            ->where('offered_product_id', $request->offered_product_id)
            ->where('requested_product_id', $request->requested_product_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->first();

        if ($existingExchange) {
            return back()->withErrors(['general' => 'You have already proposed this exchange.']);
        }

        $exchange = Exchange::create([
            'proposer_id' => $user->id,
            'offered_product_id' => $request->offered_product_id,
            'receiver_id' => $requestedProduct->user_id,
            'requested_product_id' => $request->requested_product_id,
            'status' => 'pending',
        ]);

        // Trigger notification
        $notificationService = app(\App\Services\NotificationService::class);
        $notificationService->notifyExchangeProposed($exchange);

        return redirect()->route('buyer.exchanges.index')->with('success', 'Exchange proposal sent successfully.');
    }

    /**
     * Display the specified exchange.
     */
    public function exchangesShow(Exchange $exchange)
    {
        // Ensure user is the receiver
        if ($exchange->receiver_id !== Auth::id()) {
            abort(403);
        }

        $exchange->load(['proposer', 'receiver', 'offeredProduct.category', 'requestedProduct.category']);

        return view('buyer.exchanges.show', compact('exchange'));
    }

    /**
     * Update the specified exchange.
     */
    public function exchangesUpdate(Request $request, Exchange $exchange)
    {
        // Ensure user is the receiver
        if ($exchange->receiver_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $exchange->update(['status' => $request->status]);

        return redirect()->route('buyer.exchanges.show', $exchange)->with('success', 'Exchange status updated.');
    }

    /**
     * Show the form for editing account.
     */
    public function accountEdit()
    {
        return view('buyer.account.edit');
    }

    /**
     * Update account information.
     */
    public function accountUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only(['name', 'email']));

        return back()->with('success', 'Account updated successfully.');
    }

    // ==================== CHAT METHODS ====================

    /**
     * Display all chats for the buyer.
     */
    public function chatsIndex(Request $request)
    {
        $user = Auth::user();

        $query = Chat::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('related_user_id', $user->id);
            })->whereIn('chat_type', ['customer_admin', 'customer_seller'])
            ->with(['user', 'relatedUser', 'messages'])
            ->orderBy('last_message_at', 'desc');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('chat_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $chats = $query->paginate(15);

        // Get admin chat
        $adminChat = Chat::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('related_user_id', $user->id);
            })->where('chat_type', 'customer_admin')
            ->where('status', 'active')
            ->first();

        return view('buyer.chats.index', compact('chats', 'adminChat'));
    }

    /**
     * Display a specific chat.
     */
    public function chatsShow(Chat $chat)
    {
        $user = Auth::user();

        // Ensure the buyer is part of this chat
        if ($chat->user_id !== $user->id && $chat->related_user_id !== $user->id) {
            abort(403);
        }

        $chat->load(['user', 'relatedUser', 'messages']);

        // Mark messages as read
        $chat->messages()->where('user_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return view('buyer.chats.show', compact('chat'));
    }

    /**
     * Send a message in a chat.
     */
    public function chatsStore(Request $request)
    {
        $request->validate([
            'chat_id' => 'nullable|exists:chats,id',
            'message' => 'required|string|max:5000',
            'chat_type' => 'nullable|in:customer_admin,customer_seller',
            'related_user_id' => 'nullable|exists:users,id',
            'subject' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // If chat_id is provided, reply to existing chat
        if ($request->filled('chat_id')) {
            $chat = Chat::findOrFail($request->chat_id);

            // Ensure the buyer is part of this chat
            if ($chat->user_id !== $user->id && $chat->related_user_id !== $user->id) {
                abort(403);
            }

            $message = $chat->messages()->create([
                'user_id' => $user->id,
                'sender_type' => 'customer',
                'message' => $request->message,
            ]);

            $chat->update(['last_message_at' => now()]);

            // Notify the recipient
            $recipientId = $chat->user_id === $user->id ? $chat->related_user_id : $chat->user_id;
            if ($recipientId) {
                $recipient = User::find($recipientId);
                if ($recipient) {
                    $recipient->notify(new NewChatMessageNotification($message, $chat));
                }
            }

            return redirect()->route('buyer.chats.show', $chat)->with('success', 'Message sent successfully.');
        }

        // Create new chat
        if ($request->filled('related_user_id') && $request->filled('chat_type')) {
            $relatedUser = User::findOrFail($request->related_user_id);

            // Check if chat already exists
            $existingChat = Chat::where(function($q) use ($user, $relatedUser) {
                $q->where(function($sq) use ($user, $relatedUser) {
                    $sq->where('user_id', $user->id)
                       ->where('related_user_id', $relatedUser->id);
                })->orWhere(function($sq) use ($user, $relatedUser) {
                    $sq->where('user_id', $relatedUser->id)
                       ->where('related_user_id', $user->id);
                });
            })->where('chat_type', $request->chat_type)
              ->where('status', 'active')
              ->first();

            if ($existingChat) {
                // Reply to existing chat
                $message = $existingChat->messages()->create([
                    'user_id' => $user->id,
                    'sender_type' => 'customer',
                    'message' => $request->message,
                ]);

                $existingChat->update(['last_message_at' => now()]);

                return redirect()->route('buyer.chats.show', $existingChat)->with('success', 'Message sent successfully.');
            }

            // Create new chat
            $chat = Chat::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'visitor_id' => 'customer_' . $user->id,
                'chat_type' => $request->chat_type,
                'related_user_id' => $request->related_user_id,
                'subject' => $request->subject,
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            $message = $chat->messages()->create([
                'user_id' => $user->id,
                'sender_type' => 'customer',
                'message' => $request->message,
            ]);

            // Notify the recipient
            $relatedUser->notify(new NewChatMessageNotification($message, $chat));

            return redirect()->route('buyer.chats.show', $chat)->with('success', 'Chat started successfully.');
        }

        return redirect()->back()->with('error', 'Unable to send message.');
    }

    /**
     * Get or create chat with admin.
     */
    public function chatWithAdmin()
    {
        $user = Auth::user();

        // Find or create chat with admin
        $admin = User::role('Admin')->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'No admin available to chat.');
        }

        $existingChat = Chat::where(function($q) use ($user, $admin) {
            $q->where(function($sq) use ($user, $admin) {
                $sq->where('user_id', $user->id)
                   ->where('related_user_id', $admin->id);
            })->orWhere(function($sq) use ($user, $admin) {
                $sq->where('user_id', $admin->id)
                   ->where('related_user_id', $user->id);
            });
        })->where('chat_type', 'customer_admin')
          ->where('status', 'active')
          ->with(['user', 'relatedUser', 'messages'])
          ->first();

        if (!$existingChat) {
            $existingChat = Chat::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'visitor_id' => 'customer_' . $user->id,
                'chat_type' => 'customer_admin',
                'related_user_id' => $admin->id,
                'subject' => 'Support Chat',
                'status' => 'active',
                'last_message_at' => now(),
            ]);

            $existingChat->load(['user', 'relatedUser', 'messages']);
        }

        // Mark messages as read
        $existingChat->messages()->where('user_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return view('buyer.chats.show', ['chat' => $existingChat]);
    }

    /**
     * Get unread chats count (API endpoint for real-time updates).
     */
    public function unreadChatsCount()
    {
        $user = Auth::user();

        $count = ChatMessage::whereHas('chat', function($query) use ($user) {
            $query->where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('related_user_id', $user->id);
            });
        })->where('user_id', '!=', $user->id)
          ->whereNull('read_at')
          ->count();

        // Get chats with new messages for tooltip
        $recentChats = Chat::where(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('related_user_id', $user->id);
            })->whereIn('chat_type', ['customer_admin', 'customer_seller'])
            ->where('last_message_at', '>', now()->subHours(24))
            ->with(['user', 'relatedUser'])
            ->latest('last_message_at')
            ->take(5)
            ->get();

        $chatsWithNewMessages = $recentChats->map(function($chat) {
            $otherUser = $chat->user_id === Auth::id() ? $chat->relatedUser : $chat->user;
            $unreadCount = $chat->messages()->where('user_id', '!=', Auth::id())->whereNull('read_at')->count();

            return [
                'id' => $chat->id,
                'user_name' => $otherUser ? $otherUser->name : 'Unknown',
                'chat_type' => $chat->chat_type,
                'last_message_at' => $chat->last_message_at->diffForHumans(),
                'unread_count' => $unreadCount,
                'subject' => $chat->subject,
            ];
        });

        return response()->json([
            'count' => $count,
            'chats' => $chatsWithNewMessages,
        ]);
    }
}
