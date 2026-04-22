<?php

namespace App\Notifications;

use App\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public ChatMessage $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
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
        return (new MailMessage)
            ->subject('New Message in Live Chat')
            ->line('New message from ' . $this->message->chat->name . ': ' . Str::limit($this->message->message, 50))
            ->action('View Chat', route('admin.chats.show', $this->message->chat))
            ->line('Please respond promptly.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_message',
            'chat_id' => $this->message->chat_id,
            'message' => 'New message from ' . $this->message->chat->name,
            'url' => route('admin.chats.show', $this->message->chat),
        ];
    }
}
