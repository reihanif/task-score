<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function settings($id)
    {
        $user = User::findOrFail($id);

        return view('app.account.settings', compact('user'));
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
