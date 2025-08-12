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
                                <x-heroicon-o-eye class="w-4 h-4" />
                            </a>

                            {{-- Copy Link Button --}}
                            <button type="button" onclick="copyToClipboard('{{ $event->public_url }}')"
                                class="inline-flex items-center px-2 py-1 border border-red-400 text-red-500 rounded-md hover:bg-red-50 text-sm">
                                <x-heroicon-o-clipboard class="w-4 h-4" />
                            </button>

                            {{-- Edit Button --}}
                            <a href="{{ route('events.edit', $event) }}"
                                class="inline-flex items-center px-2 py-1 border border-red-400 text-red-500 rounded-md hover:bg-red-50 text-sm">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>

                            {{-- Delete Button --}}
                            <form action="{{ route('events.destroy', $event) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this event?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                    <x-heroicon-o-trash class="w-4 h-4" />
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
