<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeMechanicNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $mechanic;

    /**
     * Create a new notification instance.
     *
     * @param object $mechanic
     */
    public function __construct($mechanic)
    {
        $this->mechanic = $mechanic;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Welcome to Pixel Car Service')
            ->greeting('Hello ' . $this->mechanic->name . ',')
            ->line('Welcome to our platform! We are excited to have you on board.')
            ->line('You can log in and start managing your mechanic profile and services.')
            ->action('Login to Your Account', url('/mechanic/login'))
            ->line('Thank you for joining us, and we look forward to working with you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
