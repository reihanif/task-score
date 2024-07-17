<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{
    public function authorizePosition(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $position = Position::findOrFail($id);
            foreach ($request->departments as $department) {
                $position->departments()->attach($department, ['added_at' => Carbon::now()->toDateTimeString(), 'adder_id' => Auth::User()->id]);
            }

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Authorizing failed');
        }

        return redirect()->back()->with('success', 'You have authorize ' . $position->name);
    }

    public function unauthorizePosition(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $position = Position::findOrFail($id);
            $position->departments()->detach($request->department);

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Remove department failed');
        }

        return redirect()->back()->with('success', 'Department has been removed from ' . $position->name . ' related departments');
    }
}
