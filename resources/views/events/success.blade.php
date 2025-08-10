<x-layouts.app>
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-100 flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-lg p-8 text-center relative overflow-hidden">
        
        <!-- Confetti Emoji -->
        <div class="absolute -top-10 -left-10 text-6xl opacity-20">🎉</div>
        <div class="absolute -bottom-10 -right-10 text-6xl opacity-20">🎉</div>

        <!-- Animated Check Icon -->
        <div class="mb-6 flex items-center justify-center">
            <div class="bg-green-100 p-4 rounded-full animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Success Heading -->
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Registration Successful!</h1>
        <p class="text-gray-600 mb-6">
            Thank you for registering for 
            <span class="font-semibold">
            </span>
            A confirmation email has been sent to your email address.
        </p>
        <!-- Back or Home Button -->
        <a href="{{ route('events.register', $event) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{ __('Submit another response') }}
        </a>
    </div>
</div>
</x-layouts.app>
