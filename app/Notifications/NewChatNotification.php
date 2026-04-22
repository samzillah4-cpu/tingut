<?php

namespace App\Notifications;

use App\Models\Chat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewChatNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Chat $chat;

    /**
     * Create a new notification instance.
     */
    public function __construct(Chat $chat)
    {
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
        return (new MailMessage)
            ->subject('New Live Chat Started')
            ->line('A new live chat has been started by ' . $this->chat->name)
            ->action('View Chat', route('admin.chats.show', $this->chat))
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
            'type' => 'new_chat',
            'chat_id' => $this->chat->id,
            'message' => 'New live chat from ' . $this->chat->name,
            'url' => route('admin.chats.show', $this->chat),
        ];
    }
}
