<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CustomAuthMiddleware;
use App\Models\Credential;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login_form()
    {
        return view('main.account.home2');
    }

    public function login_post(Request $request)
    {
        try {
            $middleware = new CustomAuthMiddleware();

            $response = $middleware->handle($request, function ($request) {
                $username = $request->session()->get('username'); // username of the user who logged in
                $loginId = $request->session()->get('loginId');

                $userType = UserProfile::where('username', $username)
                    ->where('id', $loginId)
                    ->value('user_type_id');

                switch ($userType) {
                    case 1: // Buyer 
                        return redirect()->route('landing.page');
                        break;
                    case 2: // Unverified
                        return redirect()->route('resubmission.form');
                        break;
                    case 3: // Seller
                        return redirect()->route('seller.dashboard');
                        break;
                    case 4: // Admin
                        return redirect()->route('admin.dashboard');
                        break;
                    case 5: // Manager
                        return redirect()->route('manager.dashboard');
                        break;
                    default:
                        return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
                        break;
                }
            });

            return $response;
        } catch (\Exception $e) {
            return redirect()->route('login.form')->with('error', 'An error occured. Please try again.');
        }
    }

    public function register_form()
    {
        return view('main.account.home2');
    }

    public function register_post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:user_profiles,email',
                'contact_num' => 'required|min:11|max:11|starts_with:09|unique:user_profiles,contact_num',
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'],
                'confirm_password' => 'required|same:password',
            ], [
                'first_name.required' => 'First name is required.',
                'last_name.required' => 'Last name is required.',
                'username.required' => 'Username is required.',
                'username.unique' => 'Username is already taken.',
                'email.required' => 'Email is required.',
                'email.email' => 'Invalid email.',
                'email.unique' => 'Email already exists.',
                'contact_num.required' => 'Contact Number is required.',
                'contact_num.min' => 'Use valid phone number only.',
                'contact_num.max' => 'Use valid phone number only.',
                'contact_num.starts_with' => 'Use valid phone number only.',
                'contact_num.unique' => 'Contact Number already exists.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be 8 characters.',
                'password.regex' => 'Password must include at least one uppercase letter and one special symbol.',
                'confirm_password.required' => 'Password is required.',
                'confirm_password.same' => 'Password does not match.',
            ]);

            // This block will check if the inputted infos are valid
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $user = new UserProfile();
            $user->user_type_id = 1;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->username = $request->email;
            $user->contact_num = $request->contact_num;
            $user->created_at = date('Y-m-d H:i:s');
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();

            $credentials = new Credential();
            $credentials->user_id = $user->id;
            $credentials->password = Hash::make($request->password);
            $credentials->is_deleted = 0;
            $credentials->created_at = date('Y-m-d H:i:s');
            $credentials->updated_at = date('Y-m-d H:i:s');
            $credentials->save();

            DB::commit();

            $middleware = new CustomAuthMiddleware();

            $response = $middleware->handle($request, function ($request) {
                $username = $request->session()->get('username'); // username of the user who logged in
                $loginId = $request->session()->get('loginId');

                $userType = UserProfile::where('username', $username)
                    ->where('id', $loginId)
                    ->value('user_type_id');

                switch ($userType) {
                    case 1:
                        return redirect()->route('landing.page');
                        break;
                    default:
                        return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
                        break;
                }
            });

            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('login.form')->with('error', 'An error occured. Please try again.');
        }
    }

    public function forgot_pass_form()
    {
        return view('main.account.forgotPass');
    }

    public function forgot_pass_verification_form()
    {
        return view('main.account.passReset');
    }

    public function forgot_pass_new_pass_form()
    {
        return view('main.account.newPass');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.form');
    }
}
