<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Enums\FormFields;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\EventConfirmation;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\EventRegistrationRequest;
use App\Notifications\EventReminderNotification;
use App\Notifications\EventRegistrationConfirmation;

class EventRegistrationController extends Controller
{
    public function index(Event $event)
    {
        $registrations = $event->registrations()->latest()->get();
        return view('admin.registrations.index', compact('event', 'registrations'));
    }

    public function show(Event $event)
    {
        if (!$event->is_active) {
            abort(404, 'Event not found or inactive');
        }
        if ($event->isFull()) {
            return view('events.full', compact('event'));
        }
        $formFields = $event->fields()->orderBy('created_at')->get();
        return view('events.register', compact('event', 'formFields'));
    }

    public function store(EventRegistrationRequest $request, Event $event)
    {
        $validated = $request->validated();
        
        $responses = [];
        foreach ($event->fields as $field) {
            $value = $validated["{$field->id}"] ?? null;
            if ($value !== null) {
                if ($field->field_type === 'checkbox' && is_array($value)) {
                    $responses[$field->label] = implode(', ', $value);
                } else {
                    $responses[$field->label] = $value;
                }
            }
        }

        //store the data to DB
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'email' => $validated['email'],
            'responses' => $responses,
            'registered_at' => now()
        ]);

        // Send confirmation email
        $registration->notify(new EventRegistrationConfirmation($event, $registration));

        //update 'confirmation_sent' field
        $registration->update(['confirmation_sent' => true]);
        
        return view('events.success', compact('event'));
    }

    public function sendReminder(Request $request, Event $event)
    {
        $request->validate([
            'selected' => 'required|array|min:1',
        ]);

        $registrations = EventRegistration::whereIn('id', $request->selected)->get();

        foreach ($registrations as $registration) {
            Notification::route('mail', $registration->email)
                ->notify(new EventReminderNotification($event));
            
            $registration->update(['reminder_sent' => true]);
        }

        return back()->with('success', 'Reminder email(s) sent successfully.');
    }
}
