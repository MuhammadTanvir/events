<x-layouts.app>
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
        <span class="text-gray-500 dark:text-gray-400">{{ __('Show Events') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Show Event') }}</h1>
    </div>

    <div class="mb-6">
        <a href="{{ route('events.registrations.index', $event) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{ __('Show registered users') }}
        </a>
    </div>

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
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-600">Date & Time</p>
                                            <p class="text-blue-800 font-semibold">
                                                {{ $event->event_date->format('F j, Y g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if ($event->location)
                                    <!-- Location Card -->
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                        <div class="flex items-center space-x-4">
                                            <div class="bg-green-600 rounded-full p-2">
                                                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                    </path>
                                                </svg>
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
                        <div class="mt-6 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-6">Event Form Fields</h4>

                            @if ($formFields->count())
                                <div class="space-y-4">
                                    @foreach ($formFields as $field)
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ $field->label }}
                                                @if ($field->required)
                                                    <span class="text-red-500">*</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No form fields available for this event.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
