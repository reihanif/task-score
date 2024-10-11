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
        $ranges = [
            'last 7 days',
            'last 30 days',
            'last month',
            'last 6 months',
            'this year',
            'last year',
        ];

        $selected_user = $request->user ? User::findOrFail($request->user) : auth()->user();
        $selected_range = $request->range ?? 'last 7 days';

        $unresolved_assignments = $selected_user->unresolvedAssignments->count();
        $pending_assignments = $selected_user->pendingAssignments->count();
        $resolved_assignments = $selected_user->resolvedAssignments;

        $total_score = number_format($resolved_assignments->avg('score'), 2, '.', '');
        $total_resolved_assignments = $resolved_assignments->count();

        $now = Carbon::now();

        switch ($selected_range) {
            case ('last 7 days'):
                $last_date = $now->copy();
                $data_range = 6;
                $data_serve = 'daily';
                break;
            case ('last 30 days'):
                $last_date = $now->copy();
                $data_range = 29;
                $data_serve = 'daily';
                break;
            case ('last month'):
                $last_date = $now->copy()->subMonth()->endOfMonth();
                $data_range = $now->copy()->subMonth()->daysInMonth - 1;
                $data_serve = 'daily';
                break;
            case ('last 6 months'):
                $last_date = $now->copy()->endOfMonth();
                $data_range = 5;
                $data_serve = 'monthly';
                break;
            case ('this year'):
                $last_date = $now->copy()->endOfYear();
                $data_range = 11;
                $data_serve = 'monthly';
                break;
            case ('last year'):
                $last_date = $now->copy()->subYear()->endOfYear();
                $data_range = 11;
                $data_serve = 'monthly';
                break;
        }

        $data = collect();

        switch ($data_serve) {
            case ('daily'):
                for ($i = $data_range; $i >= 0; $i--) {
                    $date = $last_date->copy()->subDays($i);

                    $data->push([
                        'x' => $date->format('D, d M'),
                        'date' => $date->format('Y-m-d'),
                        'y' => 0
                    ]);
                }

                $first_date = $last_date->copy()->subDays($data_range);
                $assignments_summary = Task::where('created_at', '>=', $first_date)
                    ->where('created_at', '<=', $last_date)
                    ->where('assignee_id', $selected_user->id)
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->pluck('total', 'date');

                $total_resolved_in_range = Task::where('created_at', '>=', $first_date)
                    ->where('created_at', '<=', $last_date)
                    ->where('assignee_id', $selected_user->id)
                    ->resolved()
                    ->count();
                break;
            case ('monthly'):
                for ($i = $data_range; $i >= 0; $i--) {
                    $date = $last_date->copy()->firstOfMonth()->subMonths($i);

                    $data->push([
                        'x' => $date->format('M Y'),
                        'date' => $date->format('Y-m'),
                        'y' => 0
                    ]);
                }

                $first_date = $last_date->copy()->firstOfMonth()->subMonths($data_range)->startOfMonth();
                $assignments_summary = Task::where('created_at', '>=', $first_date)
                    ->where('created_at', '<=', $last_date)
                    ->where('assignee_id', $selected_user->id)
                    ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total')
                    ->groupBy('month')
                    ->pluck('total', 'month');

                $total_resolved_in_range = Task::where('created_at', '>=', $first_date)
                    ->where('created_at', '<=', $last_date)
                    ->where('assignee_id', $selected_user->id)
                    ->resolved()
                    ->count();
                break;
        }

        $score_in_range = Task::where('created_at', '>=', $first_date)
            ->where('created_at', '<=', $last_date)
            ->where('assignee_id', $selected_user->id)
            ->where('resolved_at', '!=', null)
            ->get()
            ->avg('score');

        $assignments_array = $assignments_summary->toArray();
        $assignment_data = $data->map(function ($day) use ($assignments_array) {
            // Check if the date exists in the totals array and set the total
            $day['y'] = $assignments_array[$day['date']] ?? 0;
            unset($day['date']);

            return $day;
        })->toArray();

        $data_range = collect([
            'assignments' => $assignment_data,
            'total_assignment' => array_sum($assignments_array),
            'total_resolved' => $total_resolved_in_range,
            'score' => number_format($score_in_range, 2, '.', ''),
        ]);

        $data_assignments = collect([
            'unresolved' => $unresolved_assignments,
            'pending' => $pending_assignments,
            'resolved' => $total_resolved_assignments,
        ]);

        return view('app.taskscore.index', [
            'selected_user' => $selected_user,
            'ranges' => $ranges,
            'selected_range' => $selected_range,
            'total_score' => $total_score,
            'data_assignments' => $data_assignments,
            'data_range' => $data_range,
        ]);
    }
}
