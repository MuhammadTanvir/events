<x-layouts.geust-app>
    <div class="mb-8">
        <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
             <x-heroicon-o-pencil-square class="w-6 h-6 text-blue-600 mr-2" />
            Event Registration Form
        </h4>
    </div>

    <!-- Flash Message -->
    <x-flash-message />

    <div class="min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <div class="w-full bg-white max-w-2xlrounded-lg p-6">
                    <div class="space-y-6">
                        <!-- Header Card -->
                        <div class="mt-2 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Event Title</h4>
                            <p class="text-gray-700 leading-relaxed">{{ $event->title }}</p>
                            <p class="text-sm text-gray-500 mt-2">Hosted by
                                <span class="text-blue-600">{{ $event->organized_by }}</span>
                            </p>
                        </div>
                        <!-- Event Details Card -->
                        <div class="mt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Date Card -->
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-blue-600 rounded-full p-2">
                                            <x-heroicon-o-calendar-days class="w-5 h-5 text-white" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-600">Date & Time</p>
                                            <p class="text-blue-800 font-semibold">
                                                {{ $event->event_date->format('F j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if ($event->location)
                                    <!-- Location Card -->
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-green-600 rounded-full p-2">
                                                <x-heroicon-o-map-pin class="w-5 h-5 text-black" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600">Location</p>
                                                <p class="text-green-800 font-semibold">{{ $event->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($event->max_participants)
                                    <!-- Available Spots Card -->
                                    <div
                                        class="bg-purple-50 rounded-lg p-4 border border-purple-200 {{ $event->location ? '' : 'md:col-span-2' }}">
                                        <div class="flex items-center space-x-3">
                                            <div class="bg-purple-600 rounded-full p-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600">Available Spots</p>
                                                <p class="text-purple-800 font-semibold">
                                                    {{ $event->available_spots }} / {{ $event->max_participants }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Description Card -->
                            <div class="mt-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Event Description</h4>
                                <p class="text-gray-700 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        </div>
                        <!-- Registration Form Card -->
                        <div class="mt-4 border-gray-100">
                            @if ($errors->any())
                                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-red-800">
                                                There were {{ $errors->count() }} error(s) with your submission
                                            </h3>
                                            <div class="mt-2 text-sm text-red-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('events.register.store', $event->slug) }}">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Email Field Card -->
                                    <div
                                        class="bg-gray-50 rounded-lg p-4 border border-gray-200 {{ $errors->has('email') ? 'border-red-300 bg-red-50' : '' }}">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email"
                                            class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors duration-200 {{ $errors->has('email') ? 'border-red-500 ring-2 ring-red-200 focus:ring-red-500 focus:border-red-500' : 'border-gray-300' }}"
                                            id="email" name="email" value="{{ old('email') }}" required
                                            placeholder="your.email@example.com"
                                            aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
                                        @error('email')
                                            <div id="email-error" class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @foreach ($formFields as $field)
                                        <!-- Dynamic Field Card -->
                                        <div
                                            class="bg-gray-50 rounded-lg p-4 border border-gray-200 {{ $errors->has($field->id) ? 'border-red-300 bg-red-50' : '' }}">
                                            <label for="{{ $field->id }}"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                {{ $field->label }}
                                                @if ($field->required)
                                                    <span class="text-red-500">*</span>
                                                @endif
                                            </label>

                                            @switch($field->type)
                                                @case('text')
                                                @case('email')

                                                @case('number')
                                                    <input type="{{ $field->type }}"
                                                        class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors duration-200 {{ $errors->has($field->id) ? 'border-red-500 ring-2 ring-red-200 focus:ring-red-500 focus:border-red-500' : 'border-gray-300' }}"
                                                        id="{{ $field->id }}" name="{{ $field->id }}"
                                                        value="{{ old($field->id) }}"
                                                        @if ($field->required) required @endif
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">
                                                @break

                                                @case('phone')
                                                    <input type="tel"
                                                        class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors duration-200 {{ $errors->has($field->id) ? 'border-red-500 ring-2 ring-red-200 focus:ring-red-500 focus:border-red-500' : 'border-gray-300' }}"
                                                        id="{{ $field->id }}" name="{{ $field->id }}"
                                                        value="{{ old($field->id) }}"
                                                        @if ($field->required) required @endif
                                                        pattern="^(\+?[0-9]{7,15}|0[0-9]{9,14})$"
                                                        placeholder="e.g. +4919876543210 or 01987654321"
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">
                                                @break

                                                @case('textarea')
                                                    <textarea
                                                        class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white resize-none transition-colors duration-200 {{ $errors->has($field->id) ? 'border-red-500 ring-2 ring-red-200 focus:ring-red-500 focus:border-red-500' : 'border-gray-300' }}"
                                                        id="{{ $field->id }}" name="{{ $field->id }}" rows="4"
                                                        @if ($field->required) required @endif
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">{{ old($field->id) }}</textarea>
                                                @break

                                                @case('select')
                                                    <select
                                                        class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-colors duration-200 {{ $errors->has($field->id) ? 'border-red-500 ring-2 ring-red-200 focus:ring-red-500 focus:border-red-500' : 'border-gray-300' }}"
                                                        id="{{ $field->id }}" name="{{ $field->id }}"
                                                        @if ($field->required) required @endif
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">
                                                        <option value="">Select an option</option>
                                                        @foreach ($field->options as $option)
                                                            <option value="{{ $option }}"
                                                                @if (old($field->id) == $option) selected @endif>
                                                                {{ $option }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @break

                                                @case('radio')
                                                    <div class="space-y-3 mt-2" role="radiogroup"
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">
                                                        @foreach ($field->options as $option)
                                                            <div
                                                                class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors {{ $errors->has($field->id) ? 'border-red-300' : '' }}">
                                                                <input
                                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                                    type="radio" name="{{ $field->id }}"
                                                                    id="{{ $field->id }}_{{ $loop->index }}"
                                                                    value="{{ $option }}"
                                                                    @if (old($field->id) == $option) checked @endif
                                                                    @if ($field->required) required @endif>
                                                                <label class="ml-3 text-sm text-gray-700 cursor-pointer"
                                                                    for="{{ $field->id }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break

                                                @case('checkbox')
                                                    <div class="space-y-3 mt-2"
                                                        aria-describedby="{{ $errors->has($field->id) ? $field->id . '-error' : '' }}">
                                                        @foreach ($field->options as $option)
                                                            <div
                                                                class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors {{ $errors->has($field->id) ? 'border-red-300' : '' }}">
                                                                <input
                                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                                    type="checkbox" name="{{ $field->id }}[]"
                                                                    id="{{ $field->id }}_{{ $loop->index }}"
                                                                    value="{{ $option }}"
                                                                    @if (in_array($option, old($field->id, []))) checked @endif>
                                                                <label class="ml-3 text-sm text-gray-700 cursor-pointer"
                                                                    for="{{ $field->id }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break
                                            @endswitch

                                            @error($field->id)
                                                <div id="{{ $field->id }}-error"
                                                    class="mt-2 text-sm text-red-600 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Submit Button Card -->
                                <div class="mt-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4">
                                    <button type="submit"
                                        class="w-full text-black font-semibold rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 flex items-center justify-center space-x-2">
                                         <x-heroicon-o-calendar class="w-5 h-5" />
                                        <span>Register for Event</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.geust-app>
