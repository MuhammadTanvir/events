<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use App\Models\EventRegistration;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventRegistrationConfirmation extends Notification
{
    use Queueable;

    protected $event;
    protected $registration;

    /**
     * Create a new notification instance.
     */
    
    public function __construct(Event $event, EventRegistration $registration)
    {
        $this->event = $event;
        $this->registration = $registration;
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
        $event = $this->registration->event;

        return (new MailMessage)
            ->subject('Event Registration Confirmation')
            ->greeting("Hello,")
            ->line("Thank you for registering for **{$event->title}**.")
            ->line("📅 Date & Time: " . $event->event_date->format('F d, Y H:i'))
            ->line("📍 Location: " . ($event->location ?? 'Online'))
            ->line("Organized by: {$event->organized_by}")
            ->line('Here are your submitted details:')
            ->line($this->formatResponses())
            ->line('We look forward to seeing you!')
            ->salutation('Best regards, ' . $event->organized_by);
    }

    protected function formatResponses()
    {
        $lines = '';
        foreach ($this->registration->responses as $label => $value) {
            $lines .= "{$label}: {$value}\n";
        }
        return $lines;
    }
}
