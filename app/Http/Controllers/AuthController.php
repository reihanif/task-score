<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Authenticate user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        $username = $credentials['username'];

        $ldap_rdn = env('LDAP_DOMAIN') . '\\' . $username;
        $password = $credentials['password'];
        // connect ke ldap server
        $ldap_connect = ldap_connect(env('LDAP_HOST')) or die("Could not connect to LDAP server.");
        ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);

        // berhasil connect ke ldap server
        if (!$ldap_connect) {
            return redirect()->back()->withErrors('ldap', 'Failed to connect into ldap server');
        } else {
            try {
                // binding ke ldap server
                ldap_bind($ldap_connect, $ldap_rdn, $password);
                $exception = false;
            } catch (\Exception $exception) {
                session()->flash('error', __($exception->getMessage()));
            }

            // binding ke ldap server berhasil
            if (!$exception) {
                // ambil data user dari ldap
                $ldap_base_dn = 'OU=PTGN,OU=User Accounts,OU=PERTAGAS,DC=pertamina,DC=com';
                $ldap_filter = '(mailnickname=' . $username . ')';
                $ldap_search = ldap_search($ldap_connect, $ldap_base_dn, $ldap_filter);
                $ldap_results = ldap_get_entries($ldap_connect, $ldap_search);

                $user = User::firstOrCreate(
                    ['username' => $username],
                    [
                        'name' => $ldap_results[0]['displayname'][0],
                        'email' => $ldap_results[0]['mail'][0],
                        'email_verified_at' => Carbon::now()->toDateTimeString(),
                        'provider' => 'ldap'
                    ]
                );
                Permission::firstOrCreate(['user_id' => $user->id]);
                Auth::login($user);
            } else {
                Auth::attempt($credentials);
                $user = Auth::user();
            }
        }

        if(!Auth::check()) {
            // dd('failed');
            // Authentication failed
            return redirect()->route('auth.index')->withErrors('The provided credentials do not match our records.')->onlyInput('username');
        } else {
            // Authentication success
            // Update user login details
            $user->update([
                'login_attempts' => $user->login_attempts + 1,
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);

            return redirect()->route('homepage')->with('success', 'Welcome ' . $user->name);
        }
    }

    /**
     * Logging out user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.index');
    }
}
