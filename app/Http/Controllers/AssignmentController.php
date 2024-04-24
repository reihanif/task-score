<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.taskscore.assignments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignees = User::where('id', '!=', Auth::User()->id)->get()->sortBy('name');
        $assignments = Assignment::where('taskmaster_id', Auth::User()->id)->orderBy('created_at')->paginate(10);

        return view('app.taskscore.assignments.create', [
            'assignees' => $assignees,
            'assignments' => $assignments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->timetable) {
            $request['due'] = Carbon::now()->addMinutes($request->timetable);
        } elseif ($request->date && $request->time) {
            $request['due'] = Carbon::parse("$request->date $request->time");
        }

        // if ($request->attachment) {
        //     $request->validate([
        //         'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,png,jpg,jpeg,zip',
        //     ]);
        // }
        // dd($request);

        $request->validate([
            'assignee' => 'required',
            'category' => 'required',
            'subject' => 'required|unique:assignments,subject',
            'description' => 'required',
            'due' => 'required'
        ]);

        $assignment = new Assignment();
        $assignment->taskmaster_id = Auth::User()->id;
        $assignment->assigned_to = $request->assignee;
        $assignment->type = $request->category;
        $assignment->subject = $request->subject;
        $assignment->description = $request->description;
        $assignment->due = $request->due;
        $assignment->save();

        if ($request->hasFile('attachment')) {
            $clientOriginalName = $request->file('attachment')->getClientOriginalName();
            $filename = pathinfo($clientOriginalName, PATHINFO_FILENAME);
            $extension = $request->file('attachment')->getClientOriginalExtension();
            $unique_filename = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('attachment')->storeAs('public/assignment/' . $assignment->id, $unique_filename);

            $file = new File();
            $file->name = $filename;
            $file->path = $path;
            $file->type = $extension;
            $file->size = $request->file('attachment')->getSize();
            $file->fileable_id = $assignment->id;
            $file->fileable_type = Assignment::class;
            $file->save();
        }

        return redirect()->back()->with('success', 'Assignment sent to ' . $assignment->assignee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
