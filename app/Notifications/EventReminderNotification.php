<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct($event)
    {
        $this->event = $event;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reminder: ' . $this->event->title . ' is Tomorrow!')
            ->greeting('Hello!')
            ->line('This is a friendly reminder that the event you registered for is happening tomorrow.')
            ->line('📅 Date: ' . $this->event->event_date->format('d M Y, H:i'))
            ->line('📍 Location: ' . ($this->event->location ?? 'Online'))
            ->action('View Event Details', url('/events/' . $this->event->slug))
            ->line('We look forward to seeing you there!');
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
