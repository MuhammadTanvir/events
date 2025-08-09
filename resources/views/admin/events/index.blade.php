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

    <div>
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
                        <td>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-primary">View</a>

                            <button type="button" class="btn btn-outline-danger btn-sm"
                                onclick="copyToClipboard('{{ $event->public_url }}')">
                                Copy Link
                            </button>

                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-secondary">Edit</a>

                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No events created yet.</p>
                            <a href="{{ route('events.create') }}" class="btn btn-primary">Create Your First Event</a>
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
