<?php

namespace App\Notifications;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewChatMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public ChatMessage $message;
    public Chat $chat;

    /**
     * Create a new notification instance.
     */
    public function __construct(ChatMessage $message, Chat $chat)
    {
        $this->message = $message;
        $this->chat = $chat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $senderName = $this->message->user ? $this->message->user->name : $this->chat->name;

        return (new MailMessage)
            ->subject('New Message in Chat')
            ->line('New message from ' . $senderName . ': ' . Str::limit($this->message->message, 50))
            ->action('View Chat', route('seller.chats.show', $this->chat))
            ->line('Please respond promptly.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $senderName = $this->message->user ? $this->message->user->name : $this->chat->name;

        return [
            'type' => 'new_chat_message',
            'chat_id' => $this->chat->id,
            'chat_type' => $this->chat->chat_type,
            'message_id' => $this->message->id,
            'message' => 'New message from ' . $senderName,
            'preview' => Str::limit($this->message->message, 100),
            'url' => route('seller.chats.show', $this->chat),
        ];
    }
}
