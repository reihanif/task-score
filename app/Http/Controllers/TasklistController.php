<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TimeExtension;
use Illuminate\Support\Facades\Auth;

class TasklistController extends Controller
{
    /**
     * Display a listing of the tasklists.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $submissions = Submission::latest()->whereHas('task', function($query) {
            return $query->whereHas('assignment', function($query) {
                return $query->where('taskmaster_id', Auth::User()->id);
            });
        })->get();

        $time_extensions = TimeExtension::latest()->whereHas('task', function($query) {
            return $query->whereHas('assignment', function($query) {
                return $query->where('taskmaster_id', Auth::User()->id);
            });
        });

        return view('app.taskscore.assignments.tasklist', [
            'submissions' => $submissions,
            'time_extensions' => $time_extensions,
        ]);
    }
}
