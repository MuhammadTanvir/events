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
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('User') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Create User') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Create User') }}</h1>
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

            <form action="{{ route('users.store') }}" method="POST" id="userForm">
                @csrf

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">User create form</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border 
                                rounded-lg px-3 py-2 
                                focus:ring-indigo-500 
                                focus:border-indigo-500 
                                @error('name') border-red-500 @enderror"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full 
                                border rounded-lg 
                                px-3 py-2 
                                focus:ring-indigo-500 
                                focus:border-indigo-500 
                                @error('email') border-red-500 @enderror"
                                required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="role" value="admin"
                                        {{ old('role') == 'admin' ? 'checked' : '' }}
                                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                                    <span class="text-gray-700">Admin</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="role" value="user"
                                        {{ old('role') == 'user' ? 'checked' : '' }}
                                        class="text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                                    <span class="text-gray-700">User</span>
                                </label>
                            </div>

                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('users.index') }}"
                        class="bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">Cancel</a>
                    <button type="submit"
                        class="text-white font-medium bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors flex items-center justify-center cursor-pointer">Create
                        User</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
