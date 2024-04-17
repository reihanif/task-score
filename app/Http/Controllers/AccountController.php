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
        $user->update($request->all());

        return redirect()->back()->with('success', $user->name . ' account updated successfully!');
    }

    public function managePermissions($id)
    {
        $user = User::findOrFail($id);

        return view('app.account.manage-permissions', compact('user'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $permission = Permission::where('user_id', $id)->firstOrFail();

        $permission->manage_user = $request->manage_user ? true : false;
        $permission->manage_department = $request->manage_department ? true : false;
        $permission->manage_position = $request->manage_position ? true : false;
        $permission->save();

        return redirect()->back()->with('success', 'Account permission has been updated!');
    }
}
