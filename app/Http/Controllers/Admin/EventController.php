<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Enums\FormFields;
use Illuminate\Http\Request;
use App\Models\FormFieldType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('registrations')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $formFieldTypes = FormFields::cases();

        $formFieldInputTypes = [];
        foreach ($formFieldTypes as $field) {
            $formFieldInputTypes[$field->value] = $field->inputType();
        }

        return view('admin.events.create', compact('formFieldTypes', 'formFieldInputTypes'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        // Clean & normalize form fields
        $cleanedFields = collect($request->form_fields)->map(function ($field) {
            $typeEnum = FormFields::from($field['type']); // Get enum from string

            // Remove options for non-selectable types
            if ($typeEnum->inputType() !== 'selectable') {
                unset($field['options']);
            }

            // Always use the enum value for the database
            $field['type'] = $typeEnum->value;

            return $field;
        });

        DB::transaction(function () use ($request, $cleanedFields) {
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'max_participants' => $request->max_participants,
                'organized_by' => $request->organized_by,
            ]);

            foreach ($cleanedFields as $field) {
                FormFieldType::create([
                    'event_id' => $event->id,
                    'label'    => $field['label'],
                    'type'     => $field['type'], // now 'phone' for FormFields::Phone
                    'required' => $field['required'] ?? false,
                    'options'  => $field['options'] ?? null,
                ]);
            }
        });

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $formFieldTypes = FormFields::cases();

        $formFieldInputTypes = [];
        foreach ($formFieldTypes as $field) {
            $formFieldInputTypes[$field->value] = $field->inputType();
        }

        $event->load('fields');
        return view('admin.events.edit', compact('event', 'formFieldTypes', 'formFieldInputTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreEventRequest $request, Event $event)
    {
        $cleanedFields = collect($request->form_fields)->map(function ($field) {
            $typeEnum = FormFields::from($field['type']);
            if ($typeEnum->inputType() !== 'selectable') {
                unset($field['options']);
            }
            $field['type'] = $typeEnum->value;
            return $field;
        });

        DB::transaction(function () use ($event, $request, $cleanedFields) {
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'max_participants' => $request->max_participants,
                'organized_by' => $request->organized_by,
            ]);

            // Delete old fields and re-insert
            $event->fields()->delete();

            foreach ($cleanedFields as $field) {
                $event->fields()->create([
                    'label'    => $field['label'],
                    'type'     => $field['type'],
                    'required' => $field['required'] ?? false,
                    'options'  => $field['options'] ?? null,
                ]);
            }
        });

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}
