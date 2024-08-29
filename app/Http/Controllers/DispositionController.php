<?php

namespace App\Http\Controllers;

use App\Models\DeleteDispositionRequest;
use App\Models\Department;
use App\Models\Disposition;
use App\Models\DispositionTask;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DispositionController extends Controller
{
    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $assignees = Auth::User()->subordinates();
        $departments = Department::orderBy('name', 'asc')->get();
        // $dispositions = Disposition::orderBy('created_at', 'desc')->get();
        $dispositions = Disposition::with('tasks', 'attachments')->orderBy('created_at', 'desc')->get();
        return view('app.dispositions.index', [
            'assignees' => $assignees,
            'departments' => $departments,
            'dispositions' => $dispositions
        ]);
    }

    public function show(string $id)
    {
        $disposition = Disposition::with('tasks.assignee')->find($id);
        return view('app.dispositions.show', [
            'disposition' => $disposition
        ]);
    }

    public function store(Request $request)
    {   
        $request->validate([
            'sender_type' => 'required|in:internal,external',
            'sender_internal' => 'required_if:sender_type,internal',
            'sender_external' => 'required_if:sender_type,external',
            'date_of_letter' => 'required|date',
            'date_of_letter_received' => 'required|date',
            'subject' => 'required|max:255',
            'description' => 'max:2000',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments' => 'max:5',
            'assignees' => 'min:1',
            'tasks' => 'min:1'
        ]);

        DB::beginTransaction();

        try {
            $disposition = new Disposition();
            $disposition->status = "pending";
            $disposition->no_agenda = $disposition->generateLastNoAgenda();
            
            if($request->sender_type == "internal"){
                $disposition->sender_id = $request->sender_internal;
                $disposition->sender_name = null;
            }else{
                $disposition->sender_id = null;
                $disposition->sender_name = $request->sender_external;
            }

            
            $disposition->date_of_letter = $request->date_of_letter;
            $disposition->date_of_letter_received = $request->date_of_letter_received;
            $disposition->subject = $request->subject;
            $disposition->description = $request->description;
            $disposition->priority = $request->priority;
            $disposition->created_by = Auth::user()->id;

            if($request->priority === "low") {
                $due_date = Carbon::now()->addDays(5);
            } else if($request->priority === "medium") {
                $due_date = Carbon::now()->addDays(4);
            } else if($request->priority === "high") {
                $due_date = Carbon::now()->addDays(3);
            } else if($request->priority === "urgent") {
                $due_date = Carbon::now()->addDays($request->due_days)->addHours($request->due_hours)->addMinutes($request->due_minutes);
            }

            $disposition->due_date = $due_date;
            $disposition->save();

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $client_original_name = $attachment->getClientOriginalName();
                    $filename = pathinfo($client_original_name, PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $unique_filename = $filename . '_' . time() . '.' . $extension;

                    $path = $attachment->storeAs('public/dispositions/' . $disposition->id . '/attachments', $unique_filename);

                    $file = new File();
                    $file->name = $filename;
                    $file->path = $path;
                    $file->extension = $extension;
                    $file->size = $attachment->getSize();
                    $file->type = 'attachment';
                    $file->fileable_id = $disposition->id;
                    $file->fileable_type = Disposition::class;
                    $file->save();
                }
            }

            

            foreach ($request->tasks as $key => $assignee_tasks) {
                foreach ($assignee_tasks as $task) {
                    $disposition_task = new DispositionTask();
                    $disposition_task->disposition_id = $disposition->id;
                    $disposition_task->assignee_id = $request->assignees[$key];
                    $disposition_task->task = $task;
                    $disposition_task->status = "pending";
                    $disposition_task->detail = $request->details[$key];
                    $disposition_task->due_date = $due_date;
                    $disposition_task->parent_task_id = null;
                    $disposition_task->save();
                }
            }
            DB::commit();
            
            return redirect()->back()->with('success', 'Disposition created successfully');
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Create disposition failed');
        }

    }

    public function requestDelete(Request $request, $disposition_id) 
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'reason' => 'required',
            ]);

            $check_request = DeleteDispositionRequest::where('disposition_id', $disposition_id)->first();
            if($check_request) {
                return redirect()->back()->withErrors('Disposition deletion already requested');
            }

            $disposition = new DeleteDispositionRequest();
            $disposition->disposition_id = $disposition_id;
            $disposition->reason = $request->reason;
            $disposition->requested_by = Auth::user()->id;
            $disposition->status = "pending";
            $disposition->decision_at = null;
            $disposition->save();

            DB::commit();

            return redirect()->back()->with('success', 'Disposition requested successfully');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('errors', 'Request delete disposition failed');
        }
        
    }

    public function delete($disposition_id) {
        try {
            DB::beginTransaction();
            $disposition = Disposition::find($disposition_id);
            $disposition->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Disposition deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('errors', 'Delete disposition failed');
        }
        
    }
}