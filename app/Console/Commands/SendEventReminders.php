<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Console\Command;
use App\Notifications\EventReminderNotification;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to registered users 1 day before the event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::now()->addDay()->startOfDay();

        $events = Event::whereDate('event_date', $tomorrow)->with(['registrations' => function ($q) {
            $q->where('reminder_sent', false);
        }])->get();

        foreach ($events as $event) {
            foreach ($event->registrations as $registration) {
                $registration->notify(new EventReminderNotification($event));
                $registration->update(['reminder_sent' => true]);
            }
        }

        $this->info('Reminders sent successfully.');
    }
}
