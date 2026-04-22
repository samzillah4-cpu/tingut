<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionActivated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Activated Successfully')
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Your subscription to '.$this->subscription->plan->name.' has been activated successfully.')
            ->line('Subscription Details:')
            ->line('Plan: '.$this->subscription->plan->name)
            ->line('Price: NOK '.$this->subscription->plan->price.' / '.$this->subscription->plan->duration)
            ->line('Expires: '.$this->subscription->end_date->format('d.m.Y'))
            ->action('View Subscription', route('subscriptions'))
            ->line('Thank you for subscribing!')
            ->salutation('Best regards, '.config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
