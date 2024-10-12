<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CustomAuthMiddleware;
use App\Models\Credential;
use App\Models\Product;
use App\Models\Shop;
use App\Models\UserProfile;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class LoginController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $shops = Shop::all();
        
        return view('main.buyer.guest', compact('products', 'shops'));
    }

    /**
     * All functions are about the login and registration of the user.
     * 
     */
    public function login_form(Request $request)
    {
        $user = $request->session()->get('user');
        $loginId = $request->session()->get('loginId');

        if ($user) {
            $userType = UserProfile::where('username', $user->username)
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
        }

        return view('main.account.home2');
    }

    public function login_post(Request $request)
    {
        try {
            $middleware = new CustomAuthMiddleware();

            $username = $request->username;

            $user = UserProfile::where('username', $username)->first();

            if ($user && !$user->email_verified_at) {
                // Generate the OTP and set its expiry
                $otpCode = rand(100000, 999999); // 6-digit random OTP
                $user->otp_code = $otpCode;
                $user->otp_expires_at = Carbon::now()->addMinutes(5); // OTP expires in 10 minutes

                $user->save();

                // Send OTP email
                Mail::send('main.buyer.otp', ['user' => $user, 'otp' => $otpCode], function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Verify your email address with OTP');
                });

                session()->put('loginId', $user->id);

                return redirect()->route('show.otp.form')->with('error', 'Please verify your email before logging in.');
            }

            if ($user && $user->email_verified_at) {
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
            } else {
                return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
            }

            return $response;
        } catch (\Exception $e) {
            return redirect()->route('login.form')->with('error', 'An error occurred. Please try again.');
        }
    }

    // public function register_form()
    // {
    //     return view('main.account.home2');
    // }

    public function register_post(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:user_profiles,email,NULL,id',
                'contact_num' => 'required|numeric|digits:11|starts_with:09|unique:user_profiles,contact_num,NULL,id',
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'],
                'confirm_password' => 'required|same:password',
                'g-recaptcha-response' => 'required|captcha', // Updated reCAPTCHA validation rule
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
                'g-recaptcha-response.required' => 'reCAPTCHA verification failed. Please try again.',
                'g-recaptcha-response.captcha' => 'Captcha error! Please try again later or contact support.',
            ]);

            // This block will check if the inputted infos are valid
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $user = new UserProfile();
            $user->user_type_id = 1;
            $user->first_name = ucfirst(strtolower($request->first_name));
            $user->last_name = ucfirst(strtolower($request->last_name));
            $user->email = str_replace(' ', '', $request->email);
            $user->username = str_replace(' ', '', $request->email);
            $user->contact_num = $request->contact_num;
            $user->created_at = now();
            $user->updated_at = now();

            // Generate the OTP and set its expiry
            $otpCode = rand(100000, 999999); // 6-digit random OTP
            $user->otp_code = $otpCode;
            $user->otp_expires_at = Carbon::now()->addMinutes(5); // OTP expires in 10 minutes

            $user->save();

            $credentials = new Credential();
            $credentials->user_id = $user->id;
            $credentials->password = Hash::make($request->password);
            $credentials->is_deleted = 0;
            $credentials->created_at = date('Y-m-d H:i:s');
            $credentials->updated_at = date('Y-m-d H:i:s');
            $credentials->save();

            // Send OTP email
            Mail::send('main.buyer.otp', ['user' => $user, 'otp' => $otpCode], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Verify your email address with OTP');
            });

            DB::commit();

            $request->session()->put('user', $user);
            $request->session()->put('loginId', $user->id);
            $request->session()->put('username', $user->username);
            $request->session()->put('email', $user->email);

            // Redirect to OTP verification page
            return redirect()->route('show.otp.form')->with('success', 'Registration successful! Please verify your email using the OTP sent.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('login.form')->with('error', 'An error occured. Please try again.');
        }
    }

    /**
     * All functions are about sending OTP to user's email
     * For registration only.
     * 
     */
    public function showOtpForm()
    {
        try {
            // Get the logged-in user from session
            $userId = session()->get('loginId');

            // Check if userId exists in session
            if (!$userId) {
                return redirect()->route('login.form')->with('error', 'Session expired. Please log in again.');
            }

            // Fetch the user from the database
            $user = UserProfile::where('id', $userId)->first();

            // Check if user exists
            if (!$user) {
                return redirect()->route('login.form')->with('error', 'User not found. Please try again.');
            }

            // Extract the email parts
            $email = $user->email;
            $emailParts = explode('@', $email);
            $namePart = substr($emailParts[0], 0, 3); // First 3 characters of the name
            $domainPart = '@' . $emailParts[1]; // Domain part of the email

            // Concatenate censored email with 5 'x'
            $censoredEmail = $namePart . 'xxxxx' . $domainPart;

            return view('main.buyer.otp-form', compact('user', 'censoredEmail'));
        } catch (Exception $e) {
            DB::rollBack();
            // Redirect to the login page with an error message
            dd($e);
            return redirect()->route('login.form')->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            // Get the logged-in user from session
            $userId = session()->get('loginId');

            // Fetch the user from the database
            $user = UserProfile::findOrFail($userId);

            if (Carbon::now()->gt(Carbon::parse($user->otp_expires_at))) {
                $user->otp_code = null;
                $user->otp_expires_at = null;
                $user->save();

                return redirect()->back()->withErrors(['otp' => 'The OTP has expired. Please request a new one.']);

                // return $this->logout();
            }

            // Check if OTP is correct and not expired
            if ($user->otp_code === $request->otp) {
                // Mark email as verified
                $user->email_verified_at = now();
                $user->otp_code = null; // Clear OTP after successful verification
                $user->otp_expires_at = null;
                $user->save();

                $request->session()->put('user', $user);
                $request->session()->put('loginId', $user->id);
                $request->session()->put('username', $user->username);
                $request->session()->put('email', $user->email);

                return redirect()->route('landing.page')->with('success', 'Email verified successfully!');
            } else {
                return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function resendOtp(Request $request)
    {
        // Get the logged-in user from the session
        $userId = session()->get('loginId');
        $user = UserProfile::findOrFail($userId);

        if ($user->email_verified_at) {
            return redirect()->back()->with('error', 'Your email is already verified.');
        }

        // Generate a new OTP and update the expiry time
        $otpCode = rand(100000, 999999); // Generate a new 6-digit OTP
        $user->otp_code = $otpCode;
        $user->otp_expires_at = Carbon::now()->addMinutes(5); // Set the expiry for another 5 minutes
        $user->save();

        // Send the new OTP email
        Mail::send('main.buyer.otp', ['user' => $user, 'otp' => $otpCode], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verify your email address with OTP');
        });

        return redirect()->back()->with('success', 'A new OTP has been sent to your email.');
    }

    /**
     * All the functions for Google Sign In
     * 
     */
    public function googleRedirect()
    {
        return Socialite::driver("google")->redirect();
    }

    public function googleCallback(Request $request)
    {
        try {
            DB::beginTransaction();

            $googleUser = Socialite::driver("google")->user();

            // Check if account doesn't have last name
            $lname = $googleUser->user['family_name'] ?? " ";

            // Check if user already exists with the Google ID
            $existingUser = UserProfile::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            // $googlePicUrl = $googleUser->user['picture'];

            // Download the image from the URL
            // $response = Http::get($googlePicUrl);
            // if ($response->successful()) {
            //     $imageContent = $response->body();
            //     $imageName = time() . '_' . Str::random(10) . '.jpg'; // Generate a unique image name
            //     Storage::disk('public')->put('uploads/' . $imageName, $imageContent);
            // }

            if ($existingUser) {

                $user = UserProfile::findOrFail($existingUser->id);
                $user->google_id = $googleUser->id;
                $user->save();

                // User exists, log them in
                $request->session()->put('user', $existingUser);
                $request->session()->put('loginId', $existingUser->id);
                $request->session()->put('username', $existingUser->username);

                $userType = $existingUser->user_type_id;

                DB::commit();

                switch ($userType) {
                    case 1:
                        return redirect()->route('landing.page')->with('success', 'Registration successful! You are now logged in.');
                    default:
                        return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
                }
            } else {
                // Create new user
                $user = UserProfile::UpdateOrCreate([
                    'google_id' => $googleUser->id,
                    // 'picture' => $imageName,
                    'first_name' => $googleUser->user['given_name'],
                    'last_name' => $lname,
                    'email' => $googleUser->email,
                    'username' => $googleUser->email,
                    'contact_num' => " ",
                    // 'password' => bcrypt(Str::random(12)), // Hash password before saving
                    'user_type_id' => 1,
                    'email_verified_at' => now(),
                ]);

                $credential = new Credential();
                $credential->user_id = $user->id;
                $credential->password = Hash::make('klasmeyt123');
                $credential->created_at = date('Y-m-d H:i:s');
                $credential->updated_at = date('Y-m-d H:i:s');
                $credential->save();

                DB::commit();

                $request->session()->put('user', $user);
                $request->session()->put('loginId', $user->id);
                $request->session()->put('username', $user->username);

                $userType = UserProfile::where('id', $user->id)->first();
                $userType = $userType->user_type_id;

                switch ($userType) {
                    case 1:
                        return redirect()->route('landing.page')->with('success', 'Registration successful! You are now logged in.');
                    default:
                        return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('login.form')->with('error', 'Something went wrong. Please try again.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('login.form')->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * From here all the functions are about
     * 
     * FORGOT PASSWORD / PASSWORD RESETING / AND 
     * SENDING OTP TO USER's EMAIL
     * 
     */
    public function forgot_pass_form()
    {
        return view('main.account.forgotPass');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:user_profiles,email',
        ], [
            'email.exists' => 'We couldn\'t find a user with that email.',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $request->session()->put('email', $request->email);

        try {
            $user = UserProfile::where('email', $request->email)->first();

            // Generate a new OTP for password reset
            $otpCode = rand(100000, 999999); // 6-digit OTP
            $user->otp_code = $otpCode;
            $user->otp_expires_at = Carbon::now()->addMinutes(5); // OTP expires in 5 minutes
            $user->save();

            // Send the OTP to the user's email
            Mail::send('main.account.otp-passreset', ['user' => $user, 'otp' => $otpCode], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your Password Reset Code');
            });

            return redirect()->route('otp.verification.form')->with('success', 'We\'ve sent you an OTP for resetting your password.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function showOtpVerificationForm()
    {
        // Get the logged-in user from session
        $email = session()->get('email');

        $user = UserProfile::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'Invalid Request.');
        }

        // Extract the email parts
        $email = $email;
        $emailParts = explode('@', $email);
        $namePart = substr($emailParts[0], 0, 3); // First 3 characters of the name
        $domainPart = '@' . $emailParts[1]; // Domain part of the email

        // Concatenate censored email with 5 'x'
        $censoredEmail = $namePart . 'xxxxx' . $domainPart;

        return view('main.account.passReset', compact('censoredEmail'));
    }

    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6|exists:user_profiles,otp_code',
        ], [
            'otp.exists' => 'Invalid OTP'
        ]);

        $user = UserProfile::where('otp_code', $request->otp)
            ->where('otp_expires_at', '>', Carbon::now())
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Mark OTP as used
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Store user ID in session to reset the password
        session()->put('reset_user_id', $user->id);

        return redirect()->route('new.password.form')->with('success', 'OTP verified. You can now set a new password.');
    }

    public function showNewPasswordForm()
    {
        return view('main.account.newPass');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'],
            'confirm_password' => 'required|same:password',
        ], [
            'password.regex' => 'Password must include at least one uppercase letter and one special symbol.',
            'confirm_password.same' => 'The password confirmation does not match.',
        ]);

        // Get user ID from the session
        $userId = session()->get('reset_user_id');

        if (!$userId) {
            return redirect()->route('login.form')->with('error', 'Session expired. Please try again.');
        }

        $user = Credential::where('user_id', $userId)->first();

        if (!$user) {
            return redirect()->route('login.form')->with('error', 'User not found.');
        }

        // Update the user's password
        $user->is_deleted = true;
        $user->save();

        $credentials = new Credential;
        $credentials->user_id = $userId;
        $credentials->password = Hash::make($request->password);
        $credentials->save();

        // Clear reset session
        session()->forget('reset_user_id');

        return redirect()->route('login.form')->with('success', 'Your password has been reset successfully.');
    }


    // Logout
    public function logout()
    {
        Session::flush();
        return redirect()->route('login.form');
    }
}
