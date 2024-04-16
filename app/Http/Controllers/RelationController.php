<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    public function authorizePosition(Request $request, string $id)
    {
        $position = Position::findOrFail($id);
        foreach ($request->departments as $department) {
            $position->departments()->attach($department, ['added_at' => Carbon::now()->toDateTimeString(), 'adder_id' => Auth::User()->id]);
        }
        return redirect()->back()->with('success', 'You have authorize ' . $position->name);
    }

    public function unauthorizePosition(Request $request, string $id)
    {
        $position = Position::findOrFail($id);
        $position->departments()->detach($request->department);

        return redirect()->back()->with('success', 'Department has been removed from ' . $position->name . ' related departments');
    }
}
