<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;

    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp, $type)
    {
        $this->otp = $otp;
        $this->type = $type;
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
        $actionText = $this->type === 'login' ? 'sign in' : 'complete registration';
        $subject = $this->type === 'login' ? 'Your Login Verification Code' : 'Your Registration Verification Code';

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello!')
            ->line('You are receiving this email because we need to verify your identity to '.$actionText.' on TingUt.no.')
            ->line('Your verification code is:')
            ->line('')
            ->line('<div style="font-size: 24px; font-weight: bold; color: #0f5057; text-align: center; padding: 20px; border: 2px solid #0f5057; border-radius: 8px; margin: 20px 0;">'.$this->otp->code.'</div>')
            ->line('')
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not request this code, please ignore this email.')
            ->salutation('Best regards, TingUt.no Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'otp_code' => $this->otp->code,
            'type' => $this->type,
            'expires_at' => $this->otp->expires_at,
        ];
    }
}
