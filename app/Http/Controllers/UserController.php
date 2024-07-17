<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $positions = Position::orderBy('level', 'asc')->get();

        return view('app.users.index', [
            'users' => $users,
            'positions' => $positions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::orderBy('name', 'asc')->get();

        return view('app.users.create-user', [
            'positions' => $positions
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
        $request->validate([
            'email' => 'nullable|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'nullable',
            'position' => 'nullable'
        ]);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->provider = $request->provider;
            $user->username = $request->username;
            $user->name = $request->name;
            if (!is_null($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->email = $request->email;
            $user->position_id = $request->position;
            $user->role = $request->role;
            $user->save();

            $permission = new Permission();
            $permission->user_id = $user->id;
            $permission->save();

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Create user failed');
        }

        return redirect()->route('users.index')->with('success', 'User ' . $user->name . ' added successfully!');
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
        $user = User::findOrFail($id);
        $positions = Position::orderBy('name', 'asc')->get();

        return view('app.users.edit-user', [
            'user' => $user,
            'positions' => $positions
        ]);
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
            'name' => 'required',
            'email' => 'nullable|unique:users,email,' . $id . ',id',
            'username' => 'unique:users,username,' . $id . ',id',
        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->position_id = $request->position;
            $user->save();

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Update user failed');
        }

        return redirect()->route('users.index')->with('success', $user->name . ' data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $user->delete();

            // Execute database insertations
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the error appropriately
            return redirect()->back()->with('errors', 'Delete user failed');
        }

        return redirect()->back()->with('warning', 'User ' . $user->name . ' has been deleted!');
    }
}
