<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unresolved_assignments = Auth::User()->unresolvedAssignments()->count();
        $pending_assignments = Auth::User()->pendingAssignments()->count();
        $resolved_assignments = Auth::User()->resolvedAssignments->map(function ($item) {
            $item->score = $item->score();

            return $item;
        });

        $total_score = $resolved_assignments->avg('score');
        $total_resolved_assignments = $resolved_assignments->count();

        // Create an array of the past 7 days with day names and dates
        $days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dayName = Carbon::parse($date)->format('D'); // Get day name (e.g., Monday)

            $days->push([
                'x' => $dayName . ', ' . Carbon::now()->subDays($i)->format('d M'),
                'date' => $date,
                'y' => 0 // Initialize total to 0
            ]);
        }

        $assignments_last_week = Task::where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('assignee_id', Auth::user()->id)
            ->get()
            ->map(function ($item) {
                $item->score = $item->score();

                return $item;
            });

        $score_last_week = $assignments_last_week->where('resolved_at', '!=', null)->avg('score');

        // Query the database for records created in the last 7 days, grouped by date
        $assignments = Task::where('created_at', '>=', Carbon::now()->subDays(7))->where('assignee_id', Auth::user()->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');

        $assignments_array = $assignments->toArray();

        // Populate the array with the data from the query
        $days = $days->map(function ($day) use ($assignments_array) {
            // Check if the date exists in the totals array and set the total
            $day['y'] = $assignments_array[$day['date']] ?? 0;
            unset($day['date']);
            return $day;
        });

        // Convert the collection to an array
        $daysArray = $days->toArray();

        return view('app.taskscore.index', [
            'unresolved_assignments' => $unresolved_assignments,
            'pending_assignments' => $pending_assignments,
            'resolved_assignments' => $total_resolved_assignments,
            'total_score' => $total_score,
            'assignment_last_week' => $daysArray,
            'total_assignment_last_week' => $assignments_last_week->count(),
            'score_last_week' => $score_last_week
        ]);
    }
}
