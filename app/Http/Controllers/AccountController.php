<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function settings($id)
    {
        $user = User::findOrFail($id);
        $positions = Position::orderBy('name', 'asc')->get();

        return view('app.account.settings', compact('user', 'positions'));
    }

    /**
     * Change account password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        /*
        * Validate all input fields
        */
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'confirmed|min:8|different:password',
            'password_confirmation' => 'min:8',
        ]);

        if (Hash::check($request->password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->back()->with('success', 'Password changed');
        } else {
            return redirect()->back()->withErrors('Password does not match');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            if($request->update_permitted_positions) {
                $user->permitted_positions()->sync($request->permitted_positions ?? []);
            } else {
                $user->update($request->all());
            }
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($user->name . ' account updated failed!');
        }

        return redirect()->back()->with('success', $user->name . ' account updated successfully!');
    }

    public function changePosition($user, $position)
    {
        $user = User::findOrFail($user);

        try {
            $user->position_id = $position;
            $user->save();
        } catch (\Exception $e) {

            return redirect()->back()->withErrors('Failed to change position!');
        }

        return redirect()->back()->with('success', 'Position changed to ' . $user->position->name);
    }

    public function managePermissions($id)
    {
        $user = User::findOrFail($id);

        return view('app.account.manage-permissions', compact('user'));
    }

    public function updatePermissions(Request $request, $id)
    {
        /*
        * Validate all input fields
        */
        $this->validate($request, [
            'manage_user' => 'required',
            'manage_department' => 'required',
            'manage_position' => 'required',
        ]);

        $user = User::findOrFail($id);

        if($request->manage_user) {
            $user->assignPermission('manage-user');
        } else {
            $user->unassignPermission('manage-user');
        }

        if($request->manage_department) {
            $user->assignPermission('manage-department');
        } else {
            $user->unassignPermission('manage-department');
        }

        if($request->manage_position) {
            $user->assignPermission('manage-position');
        } else {
            $user->unassignPermission('manage-position');
        }

        return redirect()->back()->with('success', 'Account permission has been updated!');
    }
}
