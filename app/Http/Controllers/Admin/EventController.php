<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Enums\FormFields;
use Illuminate\Http\Request;
use App\Models\FormFieldType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.events.create', compact('formFieldTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date|after:now',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'form_fields' => 'required|array|min:1',
            'form_fields.*.label' => 'required|string|max:255',
            'form_fields.*.type' => 'required|in:' . implode(',', array_column(FormFields::cases(), 'value')),
            'form_fields.*.required' => 'boolean',
            'form_fields.*.options' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'max_participants' => $request->max_participants,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->form_fields as $field) {
                FormFieldType::create([
                    'event_id' => $event->id,
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'required' => $field['required'] ?? false,
                    'options' => $field['options'] ?? null,
                ]);
            }
        });
        

        return redirect()->route('admin.events.index')
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
