<?php

namespace App\Http\Requests;

use App\Enums\FormFields;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after:now',
            'organized_by' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'form_fields' => 'required|array|min:1',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.type' => 'required|in:' . implode(',', array_column(FormFields::cases(), 'value')),
            'form_fields.*.required' => 'boolean',
            'form_fields.*.options' => 'nullable|array',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please provide an event title.',
            'title.string' => 'The event title must be a string.',
            'title.max' => 'The event title may not be greater than 255 characters.',

            'event_date.required' => 'Please specify the event date and time.',
            'event_date.after' => 'The event date must be a future date and time.',

            'organized_by.required' => 'Please provide the organizer name.',
            'organized_by.string' => 'The organizer name must be a string.',
            'organized_by.max' => 'The organizer name may not be greater than 255 characters.',

            'location.string' => 'The location must be a valid string.',
            'location.max' => 'The location may not be greater than 255 characters.',

            'max_participants.integer' => 'Max participants must be a whole number.',
            'max_participants.min' => 'Max participants must be at least 1.',

            'form_fields.required' => 'Please add at least one registration form field.',
            'form_fields.array' => 'Form fields must be an array.',
            'form_fields.min' => 'At least one form field is required.',

            'form_fields.*.label.required' => 'Each form field must have a label.',
            'form_fields.*.label.string' => 'Form field labels must be text.',
            'form_fields.*.label.max' => 'Form field labels may not exceed 255 characters.',

            'form_fields.*.type.required' => 'Each form field must have a type.',
            'form_fields.*.type.in' => 'The selected form field type is invalid.',

            'form_fields.*.required.boolean' => 'Form field required flag must be true or false.',

            'form_fields.*.options.array' => 'Form field options must be an array.',
        ];
    }
}
