<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::orderBy('name', 'asc')->paginate(10);
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

        $department = new Department();
        $department->name = $request->name;
        $department->save();

        return redirect()->back()->with('success', 'Department ' . $department->name . ' added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);
        $positions = Position::orderBy('level')->get();
        $users = collect();
        foreach ($department->positions as $position) {
            foreach ($position->users as $user) {
                $users->push($user);
            }
        }
        $users = $users->sortBy(['name', 'asc']);

        return view('app.departments.show', compact('department','users', 'positions'));
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
                $department->positions()->attach($position, ['added_at' => Carbon::now()->toDateTimeString(), 'adder_id' => Auth::User()->id]);
            }
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
        $department = Department::findOrFail($id);

        $department->delete();

        return redirect()->back()->with('warning', 'Department ' . $department->name . ' has been deleted!');
    }
}
