<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Enums\FormFields;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\EventConfirmation;
use App\Notifications\EventRegistrationConfirmation;

class EventRegistrationController extends Controller
{
    public function show(Event $event)
    {
        return view('events.success');

        // if (!$event->is_active) {
        //     abort(404, 'Event not found or inactive');
        // }
        // if ($event->isFull()) {
        //     return view('events.full', compact('event'));
        // }
        // $formFields = $event->fields()->orderBy('created_at')->get();
        // return view('events.register', compact('event', 'formFields'));
    }

    public function store(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->with('fields')
            ->firstOrFail();

        $rules = ['email' => 'required|email'];

        foreach ($event->fields as $field) {
            $fieldRules = [];

            if ($field->is_required) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            switch ($field->field_type) {
                case FormFields::Text:
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:255';
                    break;

                case FormFields::Email:
                    $fieldRules[] = 'email';
                    break;

                case FormFields::Date:
                    $fieldRules[] = 'date';
                    break;

                case FormFields::Number:
                    $fieldRules[] = 'numeric';
                    break;

                case FormFields::Phone:
                    // Custom closure to handle JSON {"Mobile": "+4919876543210"}
                    $fieldRules[] = function ($attribute, $value, $fail) {
                        if (is_string($value)) {
                            $decoded = json_decode($value, true);
                            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['Mobile'])) {
                                $value = $decoded['Mobile'];
                            }
                        } elseif (is_array($value) && isset($value['Mobile'])) {
                            $value = $value['Mobile'];
                        }

                        if (!preg_match('/^\+?[1-9]\d{6,14}$/', $value)) {
                            $fail('Invalid phone number format. Use +491234567890 format.');
                        }
                    };
                    break;

                case FormFields::TextArea:
                    $fieldRules[] = 'string';
                    break;

                case FormFields::Radio:
                case FormFields::Select:
                    $fieldRules[] = 'in:' . implode(',', $field->options);
                    break;

                case FormFields::Checkbox:
                    $fieldRules[] = 'array';
                    break;
            }

            $rules["{$field->id}"] = $fieldRules;
        }

        $validated = $request->validate($rules);

        $responses = [];
        foreach ($event->fields as $field) {
            $value = $validated["{$field->id}"] ?? null;

            if ($value !== null) {
                if ($field->field_type === FormFields::Checkbox && is_array($value)) {
                    $responses[$field->label] = implode(', ', $value);
                } else {
                    $responses[$field->label] = $value;
                }
            }
        }

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'email' => $validated['email'],
            'responses' => $responses,
            'registered_at' => now()
        ]);

        // Send confirmation email
        $registration->notify(new EventRegistrationConfirmation($event, $registration));

        $registration->update(['confirmation_sent' => true]);

        return view('events.success', compact('event'));
    }
}
