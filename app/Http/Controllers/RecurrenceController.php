<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\RecurrencePattern;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RecurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $assignment = Assignment::findOrFail($id);
            $assignment->is_recurring = true;
            $assignment->save();

            $recurrence_end_date = $request->has('recurrence_end_date') ? new Carbon($request->recurrence_end_date) : null;
            RecurrencePattern::create([
                'assignment_id' => $assignment->id,
                'recurrence_type' => $request->repeat,
                'day_of_week' => $request->day_of_weeks ?? null,
                'day_of_month' => $request->day_of_month ?? null,
                'time' => $request->time ?? null,
                'recurrence_end_date' => $recurrence_end_date
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Setting up recurrence failed');
        }

        return redirect()->back()->with('success', 'Assignment\'s recurrence has been updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $assignment, string $recurrence)
    {
        DB::beginTransaction();

        try {
            $assignment = Assignment::findOrFail($assignment);
            $assignment->is_recurring = false;
            $assignment->save();

            $recurrence = RecurrencePattern::findOrFail($recurrence);
            $recurrence->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors('Remove recurrence failed');
        }

        return redirect()->back()->with('success', 'Assignment\'s recurrence has been removed');
    }
}
