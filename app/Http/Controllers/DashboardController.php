<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a dashboard page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->subordinate) {
            $user = User::findOrFail($request->subordinate);
        } else {
            $user = auth()->user();
        }
        $unresolved_assignments = $user->unresolvedAssignments->count();
        $pending_assignments = $user->pendingAssignments->count();
        $resolved_assignments = $user->resolvedAssignments;

        $total_score = number_format($resolved_assignments->avg('score'), 2, '.', '');
        $total_resolved_assignments = $resolved_assignments->count();

        $now = Carbon::now();
        $days_range = 6;

        $days = collect();
        for ($i = $days_range; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);

            $days->push([
                'x' => $date->format('D, d M'),
                'date' => $date->format('Y-m-d'),
                'y' => 0
            ]);
        }

        $daterange = $now->copy()->subDays($days_range);

        $score_in_range = Task::where('created_at', '>=', $daterange)
            ->where('assignee_id', $user->id)
            ->where('resolved_at', '!=', null)
            ->get()
            ->avg('score');

        $assignments_summary = Task::where('created_at', '>=', $daterange)
            ->where('assignee_id', $user->id)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $assignments_array = $assignments_summary->toArray();

        // Populate the array with the data from the query
        $assignment_data = $days->map(function ($day) use ($assignments_array) {
            // Check if the date exists in the totals array and set the total
            $day['y'] = $assignments_array[$day['date']] ?? 0;
            unset($day['date']);

            return $day;
        })->toArray();

        return view('app.taskscore.index', [
            'user' => $user,
            'unresolved_assignments' => $unresolved_assignments,
            'pending_assignments' => $pending_assignments,
            'resolved_assignments' => $total_resolved_assignments,
            'total_score' => $total_score,
            'assignment_last_week' => $assignment_data,
            'total_assignment_last_week' => array_sum($assignments_array),
            'score_last_week' => $score_in_range
        ]);
    }
}
