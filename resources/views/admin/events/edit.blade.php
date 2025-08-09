<x-layouts.app>
    <style>
        .custom-button-margin {
            margin-top: 3rem;
            /* Adjust as needed */
        }
    </style>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('events.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Events') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Edit Events') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Edit Event') }}</h1>
    </div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            {{-- Error Summary --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="list-disc pl-5 text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('events.update', $event) }}" method="POST" id="eventForm">
                @csrf
                @method('PUT')

                {{-- Basic Event Information --}}
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Event Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Title *</label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Event Date *</label>
                            <input type="datetime-local" name="event_date"
                                value="{{ old('event_date', $event->event_date->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            @error('event_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Organized by *</label>
                            <input type="text" name="organized_by"
                                value="{{ old('organized_by', $event->organized_by) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            @error('organized_by')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Max Participants</label>
                            <input type="number" name="max_participants"
                                value="{{ old('max_participants', $event->max_participants) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                min="1">
                            @error('max_participants')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Dynamic Form Builder --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Registration Form Fields</h2>

                    <div id="formFields">
                        @php
                            $fieldCounter = 0;
                        @endphp
                        @foreach ($event->fields as $formField)
                            @php
                                $fieldId = $fieldCounter++;
                            @endphp
                            <div class="border rounded-lg p-4 mb-4 form-field" data-field-id="{{ $fieldId }}">
                                <div class="flex justify-between items-center">
                                    <div></div>
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        onclick="removeField(this)">Remove</button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Field Type</label>
                                        <select name="form_fields[{{ $fieldId }}][type]"
                                            class="w-full border border-gray-300 rounded px-3 py-2 field-type"
                                            onchange="updateFieldOptions(this)">
                                            @foreach ($formFieldTypes as $type)
                                                <option value="{{ $type->value }}"
                                                    {{ old("form_fields.$fieldId.type", $formField->type) === $type->value ? 'selected' : '' }}>
                                                    {{ $type->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("form_fields.$fieldId.type")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium mb-1">Field Label</label>
                                        <input type="text" name="form_fields[{{ $fieldId }}][label]"
                                            value="{{ old("form_fields.$fieldId.label", $formField->label) }}"
                                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            required>
                                        @error("form_fields.$fieldId.label")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="form_fields[{{ $fieldId }}][required]"
                                                value="1" class="mr-2"
                                                {{ old("form_fields.$fieldId.required", $formField->required) ? 'checked' : '' }}>
                                            Required Field
                                        </label>
                                    </div>
                                </div>

                                <div class="field-options mt-4"
                                    style="display: {{ in_array(old("form_fields.$fieldId.type", $formField->type), ['select', 'radio', 'checkbox']) ? 'block' : 'none' }};">
                                    <label class="block text-sm font-medium mb-2">Options</label>
                                    @php
                                        $options = old("form_fields.$fieldId.options", $formField->options);
                                    @endphp
                                    @if ($options && is_array($options))
                                        @foreach ($options as $k => $option)
                                            <div
                                                class="option-group flex items-center gap-2 {{ $k > 0 ? 'mt-2' : '' }}">
                                                <input type="text"
                                                    name="form_fields[{{ $fieldId }}][options][]"
                                                    value="{{ $option }}" placeholder="Option"
                                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                @if ($k > 0)
                                                    <button type="button"
                                                        class="delete-option text-red-600 hover:underline text-sm">Delete</button>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="option-group flex items-center gap-2">
                                            <input type="text" name="form_fields[{{ $fieldId }}][options][]"
                                                placeholder="Option"
                                                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    @endif
                                    @error("form_fields.$fieldId.options.*")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <button type="button"
                                        class="add-option text-blue-600 hover:underline text-sm">Add Option</button>
                                </div>

                                <input type="hidden" name="form_fields[{{ $fieldId }}][id]"
                                    value="{{ $formField->id }}">
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="addField"
                        class="text-white font-medium bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">Add
                        Field</button>
                </div>

                <div class="custom-button-margin flex justify-end space-x-4">
                    <a href="{{ route('events.index') }}"
                        class="bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">Cancel</a>
                    <button type="submit"
                        class="text-white font-medium bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">Update
                        Event</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let fieldCounter = {{ $fieldCounter ?? (count($event->fields) ?? 0) }};

        document.getElementById('addField').addEventListener('click', function() {
            addFormField();
        });

        function addFormField(fieldData = null) {
            const fieldId = fieldCounter++;
            const fieldContainer = document.createElement('div');
            fieldContainer.className = 'border rounded-lg p-4 mb-4 form-field';
            fieldContainer.setAttribute('data-field-id', fieldId);

            fieldContainer.innerHTML = `
        <div class="flex justify-between items-center">
            <div></div>
            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeField(this)">Remove</button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Field Type</label>
                <select name="form_fields[${fieldId}][type]" class="w-full border border-gray-300 rounded px-3 py-2 field-type" onchange="updateFieldOptions(this)">
                    @foreach ($formFieldTypes as $type)
                        <option value="{{ $type->value }}">
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Field Label</label>
                <input type="text" name="form_fields[${fieldId}][label]" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="form_fields[${fieldId}][required]" value="1" class="mr-2">
                    Required Field
                </label>
            </div>
        </div>
        
        <div class="field-options mt-4" style="display: none;">
            <label class="block text-sm font-medium mb-2">Options</label>
            <div class="option-group flex items-center gap-2">
                <input type="text" name="form_fields[${fieldId}][options][]" placeholder="Option" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="button" class="add-option text-blue-600 hover:underline text-sm">Add Option</button>
        </div>
        
        <input type="hidden" name="form_fields[${fieldId}][id]" value="0">`; // Set to 0 for new fields

            document.getElementById('formFields').appendChild(fieldContainer);
        }

        function removeField(button) {
            const fieldCount = document.querySelectorAll('.form-field').length;
            if (fieldCount > 1) {
                button.closest('.form-field').remove();
                // Update fieldCounter to the highest existing field ID + 1
                fieldCounter = Math.max(0, ...Array.from(document.querySelectorAll('.form-field')).map(field => parseInt(
                    field.getAttribute('data-field-id')))) + 1;
            }
        }

        const formFieldInputTypes = @json($formFieldInputTypes);

        function updateFieldOptions(select) {
            const fieldContainer = select.closest('.form-field');
            const optionsDiv = fieldContainer.querySelector('.field-options');
            const addOptionBtn = fieldContainer.querySelector('.add-option');

            // Get the input type for this field
            const inputType = formFieldInputTypes[select.value];

            // If this is a regular input field, update its type
            if (!['select', 'radio', 'checkbox'].includes(select.value)) {
                optionsDiv.innerHTML = '';
                optionsDiv.style.display = 'none';
                if (addOptionBtn) addOptionBtn.classList.add('hidden');
                return;
            }

            // Reset to one option for select, radio, or checkbox
            optionsDiv.innerHTML = `
            <label class="block text-sm font-medium mb-2">Options</label>
            <div class="option-group flex items-center gap-2">
                <input type="text" name="form_fields[${select.name.split('[')[1].split(']')[0]}][options][]" placeholder="Option" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="button" class="add-option text-blue-600 hover:underline text-sm">Add Option</button>
        `;

            optionsDiv.style.display = 'block';
            if (addOptionBtn) addOptionBtn.classList.remove('hidden');
        }

        $(document).on('click', '#formFields .add-option', function() {
            const fieldGroup = $(this).closest('.form-field');
            const index = fieldGroup.data('field-id');
            const optionsDiv = fieldGroup.find('.field-options');
            const optionCount = optionsDiv.find('.option-group').length;

            const optionHtml = `
        <div class="option-group flex items-center gap-2 mt-2">
            <input type="text" name="form_fields[${index}][options][]" placeholder="Option" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            ${optionCount >= 1 ? '<button type="button" class="delete-option text-red-600 hover:underline text-sm">Delete</button>' : ''}
        </div>
    `;
            $(this).before(optionHtml);

            if (optionCount === 0) {
                optionsDiv.find('.option-group').first().append(
                    '<button type="button" class="delete-option text-red-600 hover:underline text-sm">Delete</button>'
                );
            }
        });

        $(document).on('click', '.delete-option', function() {
            const optionsDiv = $(this).closest('.field-options');
            $(this).closest('.option-group').remove();

            if (optionsDiv.find('.option-group').length === 1) {
                optionsDiv.find('.delete-option').remove();
            }
        });
    </script>
</x-layouts.app>
