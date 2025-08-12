<x-layouts.app>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('users.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('users') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('users') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('users') }}</h1>
    </div>

    <!-- Flash Message -->
    <x-flash-message />

    <!-- Create user Button -->
    <div class="mb-6">
        <a href="{{ route('users.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{ __('Create user') }}
        </a>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <table id="user-table" class="display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="flex flex-wrap gap-2">

                            {{-- Edit Button --}}
                            <a href="{{ route('users.edit', $user) }}"
                                class="inline-flex items-center px-2 py-1 border border-red-400 text-red-500 rounded-md hover:bg-red-50 text-sm">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>

                            @if (auth()->id() !== $user->id)
                                {{-- Delete Button --}}
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                        <x-heroicon-o-trash class="w-4 h-4" />
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No users created yet.</p>
                        </div>
                    </div>
                @endforelse

            </tbody>
        </table>
    </div>

    <script>
        new DataTable('#user-table', {
            lengthChange: false
        });
    </script>
</x-layouts.app>
