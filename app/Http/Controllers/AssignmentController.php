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
     * Display a listing of the unresolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function unresolved()
    {
        $assignments = Assignment::where('assigned_to', Auth::User()->id)->where('resolved_at', null)->orderBy('created_at')->paginate(10);

        return view('app.taskscore.assignments.unresolved', [
            'assignments' => $assignments,
        ]);
    }

    /**
     * Display a listing of the resolved assignments.
     *
     * @return \Illuminate\Http\Response
     */
    public function resolved()
    {
        $assignments = Assignment::where('assigned_to', Auth::User()->id)->where('resolved_at', '!=', null)->orderBy('created_at')->paginate(10);

        return view('app.taskscore.assignments.resolved', [
            'assignments' => $assignments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assignees = User::where('id', '!=', Auth::User()->id)->whereNotNull('position_id')->whereHas('position', function ($query) {
            $query->where('path', 'LIKE', '%' . Auth::User()->position->id . '%');
        })->get()->sortBy('name');

        $assignments = Assignment::where('taskmaster_id', Auth::User()->id)->doesntHave('parent')->orderBy('created_at')->paginate(10);

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

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $client_original_name = $attachment->getClientOriginalName();
                $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $unique_filename = $filename . '_' . time() . '.' . $extension;

                $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                $file = new File();
                $file->name = $filename;
                $file->path = $path;
                $file->extension = $extension;
                $file->size = $attachment->getSize();
                $file->type = 'attachment';
                $file->fileable_id = $assignment->id;
                $file->fileable_type = Assignment::class;
                $file->save();
            }
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
        $assignment = Assignment::findOrFail($id);

        return view('app.taskscore.assignments.show', [
            'assignment' => $assignment
        ]);
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
     * Resolve the specified assignment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resolve(Request $request, $id)
    {
        $request->validate([
            'resolution' => 'required'
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->timestamps = false;
        $assignment->resolution = $request->resolution;
        $assignment->resolved_at = Carbon::now()->toDateTimeString();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $client_original_name = $attachment->getClientOriginalName();
                $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $unique_filename = $filename . '_' . time() . '.' . $extension;

                $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                $file = new File();
                $file->name = $filename;
                $file->path = $path;
                $file->extension = $extension;
                $file->size = $attachment->getSize();
                $file->type = 'resolution';
                $file->fileable_id = $assignment->id;
                $file->fileable_type = Assignment::class;
                $file->save();
            }
        }

        $assignment->save();

        return redirect()->back()->with('success', $assignment->name . 'has been resolved');
    }

    /**
     * Approve the specified assignment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->timestamps = false;
        $assignment->status = 'closed';
        $assignment->closed_at = Carbon::now()->toDateTimeString();
        $assignment->save();

        return redirect()->back()->with('success', $assignment->name . 'has been approved');
    }

    /**
     * Reassign a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reassign(Request $request, $id)
    {
        $request['parent_id'] = $id;

        if ($request->timetable) {
            $request['due'] = Carbon::now()->addMinutes($request->timetable);
        } elseif ($request->date && $request->time) {
            $request['due'] = Carbon::parse("$request->date $request->time");
        }

        $request->validate([
            'parent_id' => 'required',
            'assignee' => 'required',
            'category' => 'required',
            'subject' => 'required|unique:assignments,subject',
            'description' => 'required',
            'due' => 'required'
        ]);

        $assignment = new Assignment();
        $assignment->taskmaster_id = Auth::User()->id;
        $assignment->assigned_to = $request->assignee;
        $assignment->parent_id = $request->parent_id;
        $assignment->type = $request->category;
        $assignment->subject = $request->subject;
        $assignment->description = $request->description;
        $assignment->due = $request->due;
        $assignment->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $client_original_name = $attachment->getClientOriginalName();
                $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $unique_filename = $filename . '_' . time() . '.' . $extension;

                $path = $attachment->storeAs('public/assignment/' . $assignment->id . '/attachments', $unique_filename);

                $file = new File();
                $file->name = $filename;
                $file->path = $path;
                $file->extension = $extension;
                $file->size = $attachment->getSize();
                $file->type = 'attachment';
                $file->fileable_id = $assignment->id;
                $file->fileable_type = Assignment::class;
                $file->save();
            }
        }

        return redirect()->back()->with('success', 'Assignment sent to ' . $assignment->assignee);
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->timestamps = false;
        $assignment->delete();

        return redirect()->route('taskscore.assignment.create')->with('success', $assignment->name . 'has been deleted');
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
