<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Current counts
        $totalEvents = Event::count();
        $totalUsers = User::count();

        // Example: Get previous counts (e.g., from yesterday)
        // This assumes you have a way to store/retrieve historical data
        $yesterday = Carbon::yesterday();
        $previousEvents = cache()->get('events_count_' . $yesterday->toDateString(), 0); // Example using cache
        $previousUsers = cache()->get('users_count_' . $yesterday->toDateString(), 0);

        // Calculate differences
        $eventDifference = $totalEvents - $previousEvents;
        $userDifference = $totalUsers - $previousUsers;

        // Store current counts for tomorrow's comparison (optional)
        cache()->put('events_count_' . now()->toDateString(), $totalEvents, now()->addDays(1));
        cache()->put('users_count_' . now()->toDateString(), $totalUsers, now()->addDays(1));

        return view('dashboard', compact('totalEvents', 'totalUsers', 'eventDifference', 'userDifference'));
    }
}
