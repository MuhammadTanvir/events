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
        <span class="text-gray-500 dark:text-gray-400">{{ __('Events') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Events') }}</h1>
    </div>

    <!-- Flash Message -->
    <x-flash-message />

    <!-- Create Event Button -->
    <div class="mb-6">
        <a href="{{ route('events.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg> --}}
            {{ __('Create Event') }}
        </a>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <table id="example" class="display">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Event date</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Registered User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->event_date->format('M d, Y H:i') }}</td>
                        <td> {{ $event->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>{{ $event->location }}</td>
                        <td> {{ $event->registrations->count() }}</td>
                        <td class="flex flex-wrap gap-2">

                            {{-- View Button --}}
                            <a href="{{ route('events.show', $event) }}"
                                class="inline-flex items-center px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943
                     9.542 7-1.274 4.057-5.065 7-9.542 7
                     -4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            {{-- Copy Link Button --}}
                            <button type="button" onclick="copyToClipboard('{{ $event->public_url }}')"
                                class="inline-flex items-center px-2 py-1 border border-red-400 text-red-500 rounded-md hover:bg-red-50 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0l.707.707a4 4 0 010 5.656
                     l-3.536 3.536a4 4 0 01-5.656 0l-.707-.707" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.172 13.828a4 4 0 01-5.656 0l-.707-.707
                     a4 4 0 010-5.656l3.536-3.536a4 4 0 015.656 0l.707.707" />
                                </svg>
                            </button>

                            {{-- Edit Button --}}
                            <a href="{{ route('events.edit', $event) }}"
                                class="inline-flex items-center px-2 py-1 bg-gray-600 text-red rounded-md hover:bg-gray-700 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5
                     M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                            </a>

                            {{-- Delete Button --}}
                            <form action="{{ route('events.destroy', $event) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                         a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                         M1 7h22M8 7V5a2 2 0 012-2h4
                         a2 2 0 012 2v2" />
                                    </svg>

                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No events created yet.</p>
                        </div>
                    </div>
                @endforelse

            </tbody>
        </table>
    </div>

    <script>
        new DataTable('#example', {
            lengthChange: false
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Registration link copied to clipboard!');
            });
        }
    </script>
</x-layouts.app>
