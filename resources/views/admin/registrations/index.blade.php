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
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Registared users for : {{ $event->title }}</h1>
    </div>

    <!-- Flash Message -->
    <x-flash-message />

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="{{ route('events.registrations.reminder', $event) }}" method="POST">
            @csrf
            <div class="mb-2">
                <button type="submit"
                    class="text-white font-medium bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">
                    Send Reminder Email
                </button>
            </div>

            <table id="example" class="display">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th>Reminder Sent</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $reg)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected[]" value="{{ $reg->id }}">
                            </td>
                            <td>{{ $reg->email }}</td>
                            <td>{{ $reg->registered_at }}</td>
                            <td>{{ $reg->reminder_sent ? '✅' : '❌' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            document.querySelectorAll('input[name="selected[]"]').forEach(cb => cb.checked = this.checked);
        });
        new DataTable('#example', {
            "lengthChange": false,
            "order": [[2, 'asc']],
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }]
        });
    </script>
</x-layouts.app>
