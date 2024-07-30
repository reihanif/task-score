<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $ldap_rdn = config('ldap.domain') . '\\' . $username;
        $password = $credentials['password'];
        // connect to ldap server
        $ldap_connect = ldap_connect(config('ldap.host')) or die("Could not connect to LDAP server.");
        ldap_set_option($ldap_connect, LDAP_OPT_PROTOCOL_VERSION, 3);

        // successfully connect to ldap server
        if (!$ldap_connect) {
            return redirect()->back()->withErrors('ldap', 'Failed to connect into ldap server');
        } else {
            try {
                // binding to ldap server using credentials
                ldap_bind($ldap_connect, $ldap_rdn, $password);
                $exception = false;
            } catch (\Exception $exception) {
                session()->flash('error', 'Incorrect username or password');
            }

            // successfully binding to ldap server
            if (!$exception) {
                // filtering user and get specific user data from ldap
                $ldap_base_dn = 'OU=PTGN,OU=User Accounts,OU=PERTAGAS,DC=pertamina,DC=com';
                $ldap_filter = '(mailnickname=' . $username . ')';
                $ldap_search = ldap_search($ldap_connect, $ldap_base_dn, $ldap_filter);
                $ldap_results = ldap_get_entries($ldap_connect, $ldap_search);

                DB::beginTransaction();

                try {
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

                    // Execute database insertations
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    // Handle the error appropriately
                    return redirect()->back()->with('errors', 'Login failed due to server errors');
                }
            } else {
                Auth::attempt($credentials);
                $user = Auth::user();
            }
        }

        if (Auth::check()) {
            // If authentication success
            // Update user login details without updated_at timestamps
            DB::beginTransaction();

            try {
                $user->timestamps = false;
                $user->update([
                    'login_attempts' => $user->login_attempts + 1,
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp()
                ]);

                // Execute database insertations
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                // Handle the error appropriately
                return redirect()->back()->with('errors', 'Update assignment failed');
            }

            return redirect()->intended('homepage')->with('success', 'Welcome ' . $user->name);
        }

        // Authentication failed
        return redirect()->route('auth.index')->withErrors('Username or password invalid')->onlyInput('username');
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
