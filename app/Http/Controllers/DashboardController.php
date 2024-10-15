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

        $range_assignments = $this->getAssignmentSummary($selected_user, $selected_range);

        $overall_assignments = collect([
            'unresolved' => $selected_user->unresolvedAssignments->count(),
            'pending' => $selected_user->pendingAssignments->count(),
            'resolved' => $selected_user->resolvedAssignments->count(),
            'score' => number_format($selected_user->tasks->avg('score'), 2, '.', ''),
        ]);

        return view('app.taskscore.index', [
            'selected_user' => $selected_user,
            'ranges' => $ranges,
            'selected_range' => $selected_range,
            'overall_assignments' => $overall_assignments,
            'range_assignments' => $range_assignments,
        ]);
    }

    private function getDateRangeAndServeType($selected_range, $now)
    {
        switch ($selected_range) {
            case 'last 7 days':
                return [$now->copy(), 6, 'daily'];
            case 'last 30 days':
                return [$now->copy(), 29, 'daily'];
            case 'last month':
                return [$now->copy()->subMonth()->endOfMonth(), $now->copy()->subMonth()->daysInMonth - 1, 'daily'];
            case 'last 6 months':
                return [$now->copy()->endOfMonth(), 5, 'monthly'];
            case 'this year':
                return [$now->copy()->endOfYear(), 11, 'monthly'];
            case 'last year':
                return [$now->copy()->subYear()->endOfYear(), 11, 'monthly'];
        }
    }

    private function generateChartData($data_range, $last_date, $data_serve)
    {
        $data = collect();
        if ($data_serve == 'daily') {
            for ($i = $data_range; $i >= 0; $i--) {
                $date = $last_date->copy()->subDays($i);
                $data->push(['x' => $date->format('Y-m-d'), 'date' => $date->format('Y-m-d'), 'y' => 0]);
            }
        } else {
            for ($i = $data_range; $i >= 0; $i--) {
                $date = $last_date->copy()->firstOfMonth()->subMonths($i);
                $data->push(['x' => $date->format('Y-m'), 'date' => $date->format('Y-m'), 'y' => 0]);
            }
        }

        return $data;
    }

    private function getAssignmentSummary($user, $range)
    {
        $now = Carbon::now();

        [$last_date, $data_range, $data_serve] = $this->getDateRangeAndServeType($range, $now);
        $data_structure = $this->generateChartData($data_range, $last_date, $data_serve);

        $first_date = $data_serve == 'daily'
            ? $last_date->copy()->subDays($data_range)
            : $last_date->copy()->firstOfMonth()->subMonths($data_range)->startOfMonth();

        $date_format = $data_serve == 'daily' ? 'DATE(created_at)' : 'DATE_FORMAT(created_at, "%Y-%m")';

        $query = Task::where('created_at', '>=', $first_date)
            ->where('created_at', '<=', $last_date)
            ->where('assignee_id', $user->id);

        $assignments_summary = $query->clone()
            ->selectRaw("$date_format as period, COUNT(*) as total")
            ->groupBy('period')
            ->pluck('total', 'period')
            ->toArray();

        $assignment_data = $data_structure->map(function ($day) use ($assignments_summary) {
            $day['y'] = $assignments_summary[$day['date']] ?? 0;
            unset($day['date']);

            return $day;
        })->toArray();

        $total_assignment = array_sum($assignments_summary);
        $total_resolved = $query->clone()->resolved()->count();
        $score = $query->clone()->resolved()->get()->avg('score');

        return collect([
            'assignments' => $assignment_data,
            'total_assignment' => $total_assignment,
            'total_resolved' => $total_resolved,
            'score' => number_format($score, 2, '.', ''),
        ]);
    }
}
