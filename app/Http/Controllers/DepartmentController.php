<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderBy('name', 'asc')->get();
        $positions = Position::orderBy('level')->get();

        return view('app.departments.index', [
            'departments' => $departments,
            'positions' => $positions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name'
        ]);

        DB::beginTransaction();

        try {
            $department = new Department();
            $department->name = $request->name;
            $department->save();

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Create department failed');
        }

        return redirect()->back()->with('success', 'Department ' . $department->name . ' added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $positions = Position::orderBy('level')->get();

        if ($request->daterange) {
            $dates = explode(' - ', $request->daterange);

            $startDate = Carbon::parse($dates[0])->setTime(00, 00, 00);
            $endDate = Carbon::parse($dates[1])->setTime(23, 59, 59);
        } else {
            $startDate = Carbon::now()->startOfMonth()->setTime(22, 32, 5);
            $endDate = Carbon::now()->endOfMonth()->setTime(23, 59, 59);
        }

        $users_has_tasks_count = $department->users->filter(function ($user) use ($startDate, $endDate) {
            return $user->tasks()
                ->whereBetween('created_at', [$startDate, $endDate])
                ->exists();
        })->count();

        $assignments_radial = [
            'data' => $department->users_count ? number_format($users_has_tasks_count / $department->users_count * 100, 2, '.', '') : 0,
            'total_users' => $department->users_count,
            'total_users_has_tasks' => $users_has_tasks_count,
            'start' => $startDate,
            'end' => $endDate
        ];

        $assignments_treemap = collect();
        foreach ($department->users as $user) {
            if ($user->assignments->count() > 0) {
                $assignments_treemap->push(['x' => $user->name, 'y' => $user->assignments->count()]);
            }
        }
        $assignments_treemap = $assignments_treemap->toArray();

        return view('app.departments.show', compact('department', 'positions', 'assignments_radial', 'assignments_treemap'));
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
        $request->validate([
            'name' => 'required|unique:departments,name,' . $id . ',id'
        ]);

        DB::beginTransaction();

        try {
            $department = Department::findOrFail($id);
            $department->name = $request->name;
            $department->save();

            $current_positions = $department->positions->pluck('id')->toArray();
            if ($request->positions) {
                $submitted_positions = $request->positions;
            } else {
                $submitted_positions = [];
            }
            foreach ($current_positions as $current_position) {
                if (!in_array($current_position, $submitted_positions)) {
                    $department->positions()->detach($current_position);
                }
            }

            foreach ($submitted_positions as $position) {
                if (!in_array($position, $current_positions)) {
                    $department->positions()->attach($position, ['added_at' => Carbon::now()->toDateTimeString(), 'adder_id' => auth()->id()]);
                }
            }

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Department update failed');
        }


        return redirect()->back()->with('success', 'Department ' . $department->name . ' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $department = Department::findOrFail($id);

            $department->delete();
            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Delete department failed');
        }

        return redirect()->back()->with('warning', 'Department ' . $department->name . ' has been deleted!');
    }
}
