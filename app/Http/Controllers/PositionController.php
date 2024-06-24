<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::orderBy('level', 'asc')->get();
        $superiors = Position::orderBy('level', 'asc')->get();

        return view('app.positions.index', [
            'positions' => $positions,
            'superiors' => $superiors
        ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:positions,name'
        ]);


        $position = new Position();
        $position->name = $request->name;
        if (!is_null($request->superior)) {
            $position->parent_id = $request->superior;
            $superior = Position::select('level', 'path')->where('id', $request->superior);
            $position->level = $superior->pluck('level')[0] + 1;
            $position->path = $superior->pluck('path')[0] . $request->superior . '\\';
        }
        $position->save();

        return redirect()->back()->with('success', 'Position ' . $position->name . ' added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::findOrFail($id);
        $positions = Position::orderBy('level', 'asc');
        $departments = Department::all();

        return view('app.positions.show', compact('position', 'positions', 'departments'));
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
        $request->validate([
            'name' => 'required|unique:positions,name,' . $id . ',id'
        ]);

        $position = Position::findOrFail($id);
        $position_current_level = $position->level;

        $position->name = $request->name;
        if (!is_null($request->superior)) {
            $position->parent_id = $request->superior;
            $superior = Position::select('level', 'path')->where('id', $request->superior);
            $position->level = $superior->pluck('level')[0] + 1;
            $position->path = $superior->pluck('path')[0] . $request->superior . '\\';
        }

        $childs = Position::where('path', 'LIKE', '%' . $id . '%')->get();
        foreach ($childs as $child) {
            $path_to_parent = $id . Str::after($child->path, $id);
            $child_level_gap = $child->level - $position_current_level;
            $child->level = $position->level + $child_level_gap;
            $child->path = $position->path . $path_to_parent;
            $child->save();
        }
        $position->save();

        return redirect()->back()->with('success', 'Position ' . $position->name . ' updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::findOrFail($id);

        $position->delete();

        return redirect()->back()->with('warning', 'Position ' . $position->name . ' has been deleted!');
    }
}
