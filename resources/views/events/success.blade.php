<x-layouts.geust-app>
    <div class="min-h-screen flex flex-col">

        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto text-center">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <div class="text-green-500 text-6xl mb-4">✓</div>
                    <h1 class="text-3xl font-bold text-green-600 mb-4">Registration Successful!</h1>
                    <p class="text-lg text-gray-600 mb-6">
                        Thank you for registering for <strong>{{ $event->title }}</strong>.
                    </p>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="font-semibold mb-3">Event Details:</h3>
                        <p><strong>Date:</strong> {{ $event->event_date->format('l, F j, Y \a\t g:i A') }}</p>
                        @if($event->location)
                        <p><strong>Location:</strong> {{ $event->location }}</p>
                        @endif
                    </div>

                    <div class="text-sm text-gray-600">
                        <p>A confirmation email has been sent to your email address.</p>
                        <p>You will receive a reminder email one day before the event.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.geust-app>