<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Message;
use App\Models\Exchange;
use App\Models\Product;
use App\Models\GiveawayRequest;

class NotificationService
{
    /**
     * Create a notification for a user.
     */
    public function createNotification(int $userId, string $type, string $title, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Notify when a message is received.
     */
    public function notifyMessageReceived(Message $message): void
    {
        $this->createNotification(
            $message->receiver_id,
            'message_received',
            'New Message',
            "You received a new message from {$message->sender->name} about '{$message->product->title}'",
            [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'product_id' => $message->product_id,
            ]
        );
    }

    /**
     * Notify when an exchange is proposed.
     */
    public function notifyExchangeProposed(Exchange $exchange): void
    {
        // Notify the product owner
        $this->createNotification(
            $exchange->requestedProduct->user_id,
            'exchange_proposed',
            'Exchange Proposal',
            "{$exchange->proposer->name} wants to exchange their '{$exchange->offeredProduct->title}' for your '{$exchange->requestedProduct->title}'",
            [
                'exchange_id' => $exchange->id,
                'buyer_id' => $exchange->proposer_id,
                'product_id' => $exchange->requested_product_id,
                'offered_product_id' => $exchange->offered_product_id,
            ]
        );
    }

    /**
     * Notify when an exchange is accepted.
     */
    public function notifyExchangeAccepted(Exchange $exchange): void
    {
        // Notify the buyer
        $this->createNotification(
            $exchange->proposer_id,
            'exchange_accepted',
            'Exchange Accepted',
            "{$exchange->requestedProduct->user->name} accepted your exchange proposal for '{$exchange->requestedProduct->title}'",
            [
                'exchange_id' => $exchange->id,
                'seller_id' => $exchange->requestedProduct->user_id,
                'product_id' => $exchange->requested_product_id,
            ]
        );
    }

    /**
     * Notify when an exchange is rejected.
     */
    public function notifyExchangeRejected(Exchange $exchange): void
    {
        // Notify the buyer
        $this->createNotification(
            $exchange->proposer_id,
            'exchange_rejected',
            'Exchange Rejected',
            "{$exchange->requestedProduct->user->name} declined your exchange proposal for '{$exchange->requestedProduct->title}'",
            [
                'exchange_id' => $exchange->id,
                'seller_id' => $exchange->requestedProduct->user_id,
                'product_id' => $exchange->requested_product_id,
            ]
        );
    }

    /**
     * Notify when an exchange is completed.
     */
    public function notifyExchangeCompleted(Exchange $exchange): void
    {
        // Notify both parties
        $this->createNotification(
            $exchange->proposer_id,
            'exchange_completed',
            'Exchange Completed',
            "Your exchange with {$exchange->requestedProduct->user->name} for '{$exchange->requestedProduct->title}' has been completed successfully",
            [
                'exchange_id' => $exchange->id,
                'seller_id' => $exchange->requestedProduct->user_id,
                'product_id' => $exchange->requested_product_id,
            ]
        );

        $this->createNotification(
            $exchange->requestedProduct->user_id,
            'exchange_completed',
            'Exchange Completed',
            "Your exchange with {$exchange->proposer->name} for '{$exchange->requestedProduct->title}' has been completed successfully",
            [
                'exchange_id' => $exchange->id,
                'buyer_id' => $exchange->proposer_id,
                'product_id' => $exchange->requested_product_id,
            ]
        );
    }

    /**
     * Notify when a giveaway request is submitted.
     */
    public function notifyGiveawayRequested(GiveawayRequest $giveawayRequest): void
    {
        // Notify the product owner
        $this->createNotification(
            $giveawayRequest->product->user_id,
            'giveaway_requested',
            'Giveaway Request',
            "{$giveawayRequest->requester->name} requested your giveaway item '{$giveawayRequest->product->title}'",
            [
                'giveaway_request_id' => $giveawayRequest->id,
                'requester_id' => $giveawayRequest->requester_id,
                'product_id' => $giveawayRequest->product_id,
            ]
        );
    }

    /**
     * Notify when a giveaway request is approved.
     */
    public function notifyGiveawayApproved(GiveawayRequest $giveawayRequest): void
    {
        // Notify the requester
        $this->createNotification(
            $giveawayRequest->requester_id,
            'giveaway_approved',
            'Giveaway Approved',
            "Congratulations! {$giveawayRequest->product->user->name} approved your request for the giveaway item '{$giveawayRequest->product->title}'",
            [
                'giveaway_request_id' => $giveawayRequest->id,
                'seller_id' => $giveawayRequest->product->user_id,
                'product_id' => $giveawayRequest->product_id,
            ]
        );
    }

    /**
     * Notify when a giveaway request is rejected.
     */
    public function notifyGiveawayRejected(GiveawayRequest $giveawayRequest): void
    {
        // Notify the requester
        $this->createNotification(
            $giveawayRequest->requester_id,
            'giveaway_rejected',
            'Giveaway Request Declined',
            "{$giveawayRequest->product->user->name} declined your request for the giveaway item '{$giveawayRequest->product->title}'",
            [
                'giveaway_request_id' => $giveawayRequest->id,
                'seller_id' => $giveawayRequest->product->user_id,
                'product_id' => $giveawayRequest->product_id,
            ]
        );
    }

    /**
     * Notify when a product is created (for admins).
     */
    public function notifyProductCreated(Product $product): void
    {
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            $this->createNotification(
                $admin->id,
                'product_created',
                'New Product Listed',
                "{$product->user->name} listed a new product: '{$product->title}'",
                [
                    'product_id' => $product->id,
                    'user_id' => $product->user_id,
                ]
            );
        }
    }

    /**
     * Notify when a user registers (for admins).
     */
    public function notifyUserRegistered(User $user): void
    {
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            $this->createNotification(
                $admin->id,
                'user_registered',
                'New User Registration',
                "{$user->name} ({$user->email}) has registered on the platform",
                [
                    'user_id' => $user->id,
                ]
            );
        }
    }

    /**
     * Send admin notification to all admins.
     */
    public function notifyAdmins(string $title, string $message, array $data = []): void
    {
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            $this->createNotification(
                $admin->id,
                'admin_message',
                $title,
                $message,
                $data
            );
        }
    }

    /**
     * Get unread notifications count for a user.
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->unread()
            ->count();
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(int $userId): void
    {
        Notification::where('user_id', $userId)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get recent notifications for a user.
     */
    public function getRecentNotifications(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
