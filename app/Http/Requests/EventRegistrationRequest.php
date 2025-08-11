<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Enums\FormFields;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // Get the event from route model binding
        $event = $this->route('event');

        // If event is null, try to find it by slug (fallback)
        if (!$event) {
            $slug = $this->route('slug');
            $event = Event::where('slug', $slug)
                ->where('is_active', true)
                ->with('fields')
                ->firstOrFail();
        } else {
            // Load fields relationship if not already loaded
            if (!$event->relationLoaded('fields')) {
                $event->load('fields');
            }
        }

        $this->event = $event;

        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('event_registrations')->where(function ($query) use ($event) {
                    return $query->where('event_id', $event->id);
                })
            ]
        ];

        foreach ($this->event->fields as $field) {
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
                            $fail("The {$attribute} must be a valid phone number (e.g., +491234567890).");
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

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'You have already registered for this event with this email address.',
        ];

        foreach ($this->event->fields as $field) {
            if ($field->is_required) {
                $messages["{$field->id}.required"] = "The {$field->label} field is required.";
            }

            switch ($field->field_type) {
                case FormFields::Text:
                    $messages["{$field->id}.string"] = "The {$field->label} must be a valid text.";
                    $messages["{$field->id}.max"] = "The {$field->label} may not be longer than 255 characters.";
                    break;

                case FormFields::Email:
                    $messages["{$field->id}.email"] = "The {$field->label} must be a valid email address.";
                    break;

                case FormFields::Date:
                    $messages["{$field->id}.date"] = "The {$field->label} must be a valid date.";
                    break;

                case FormFields::Number:
                    $messages["{$field->id}.numeric"] = "The {$field->label} must be a number.";
                    break;

                case FormFields::TextArea:
                    $messages["{$field->id}.string"] = "The {$field->label} must be valid text.";
                    break;

                case FormFields::Radio:
                case FormFields::Select:
                    $messages["{$field->id}.in"] = "Please select a valid option for {$field->label}.";
                    break;

                case FormFields::Checkbox:
                    $messages["{$field->id}.array"] = "The {$field->label} selection is invalid.";
                    break;
            }
        }

        return $messages;
    }

    public function getEvent()
    {
        return $this->event;
    }
}
