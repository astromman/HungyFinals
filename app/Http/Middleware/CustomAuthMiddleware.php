<?php

namespace App\Http\Middleware;

use App\Models\Credential;
use App\Models\UserProfile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;


class CustomAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Session::has('loginId')) {
                return $next($request);
            }

            $username = $request->input('username');
            $password = $request->input('password');

            if (!$username || !$password) {
                return redirect()->route('login.form')->withErrors(['error' => 'Invalid username or password']);
            }

            $user = UserProfile::with('userType')->where('username', $username)->first();

            if (!$user) {
                return redirect()->route('login.form')->withErrors(['error' => 'Invalid username or password']);
            }

            $credentials = Credential::where('user_id', $user->id)->where('is_deleted', 0)->first();

            if (!$credentials || !Hash::check($password, $credentials->password)) {
                return redirect()->route('login.form')->withErrors(['error' => 'Invalid username or password']);
            }

            $request->session()->put('user', $user);
            $request->session()->put('loginId', $user->id);
            $request->session()->put('username', $user->username);
            $request->session()->put('email', $user->email);

            return $next($request);
        } catch (\Exception $e) {
            // dd($e);
            return redirect()->back()->withErrors(['error' => 'Something went wrong. Please Try again.']);
        }
    }
}
