<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Dashboard') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Welcome to the dashboard') }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
        <!-- Users Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Users') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1 count-up"
                        data-target="{{ $totalUsers }}">0</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        @if ($userDifference > 0)
                            <x-heroicon-o-arrow-long-up class="h-4 w-4 mr-1 text-green-500" />
                            +{{ $userDifference }}
                        @elseif ($userDifference < 0)
                            <x-heroicon-o-arrow-long-down class="h-4 w-4 mr-1 text-red-500" />
                            {{ $userDifference }}
                        @else
                            <span class="h-4 w-4 mr-1"></span> <!-- Placeholder for no change -->
                            0
                        @endif
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <x-heroicon-o-users class="w-6 h-6 text-gray-600" />
                </div>
            </div>
        </div>
        <!-- Events Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Event') }}</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100 mt-1 count-up"
                        data-target="{{ $totalEvents }}">0</p>
                    <p class="text-xs text-gray-500 flex items-center mt-1">
                        @if ($eventDifference > 0)
                            <x-heroicon-o-arrow-long-up class="h-4 w-4 mr-1 text-green-500" />
                            +{{ $eventDifference }}
                        @elseif ($eventDifference < 0)
                            <x-heroicon-o-arrow-long-down class="h-4 w-4 mr-1 text-red-500" />
                            {{ $eventDifference }}
                        @else
                            <span class="h-4 w-4 mr-1"></span> <!-- Placeholder for no change -->
                            0
                        @endif
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <x-heroicon-o-calendar-days class="w-6 h-6 text-gray-600" />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll(".count-up");
            const duration = 1500; // total animation time in ms -increase for slower
            const frameRate = 30; // ms between frames

            counters.forEach(counter => {
                const target = +counter.getAttribute("data-target");
                let count = 0;
                const increment = target / (duration / frameRate);

                const updateCount = () => {
                    count += increment;
                    if (count < target) {
                        counter.innerText = Math.floor(count);
                        setTimeout(updateCount, frameRate);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        });
    </script>

</x-layouts.app>
