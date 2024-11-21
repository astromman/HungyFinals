<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Building;
use App\Models\Credential;
use App\Models\Permit;
use App\Models\Shop;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManagerController extends Controller
{
    public function manager_dashboard(Request $request)
    {
        // dd($request->start_date, $request->end_date);

        $userId = $request->session()->get('loginId');

        $user = UserProfile::where('id', $userId)->first();

        $applications = Shop::join('user_profiles', 'user_profiles.id', 'shops.user_id')
            ->join('permits', 'shops.id', 'permits.shop_id')
            ->where('permits.status', 'Pending')
            ->where('user_profiles.seller_building_id', $user->manager_building_id)
            ->count();

        $verifiedShops = Shop::join('user_profiles', 'user_profiles.id', 'shops.user_id')
            ->where('shops.status', 'Verified')
            ->where('user_profiles.seller_building_id', $user->manager_building_id)
            ->count();

        // Fetch total orders per shop (unique order_reference counts as one)
        $ordersPerShopQuery = DB::table('orders')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->where('user_profiles.seller_building_id', $user->manager_building_id)
            ->where('orders.order_status', 'Completed')
            ->select('shops.shop_name', DB::raw('COUNT(DISTINCT orders.order_reference) as total_orders'))
            ->groupBy('shops.shop_name');

        // Fetch total sales per shop per day
        $salesPerShop = DB::table('orders')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->where('user_profiles.seller_building_id', $user->manager_building_id)
            ->where('orders.order_status', 'Completed')
            ->select('shops.shop_name', DB::raw('SUM(orders.total) as total_sales'), DB::raw('DATE(orders.created_at) as sale_date'))
            ->groupBy('shops.shop_name', 'sale_date')
            ->orderBy('sale_date')
            ->get();

        // Apply date range filter
        if ($request->start_date && $request->end_date) {
            $ordersPerShopQuery->whereBetween(DB::raw('DATE(orders.created_at)'), [$request->start_date, $request->end_date]);
        }

        // Apply month filter if provided
        if ($request->month) {
            $ordersPerShopQuery->whereMonth('orders.created_at', $request->month);
        }

        $ordersPerShop = $ordersPerShopQuery->get();

        // Fetch sales per shop per day with optional date filtering
        $salesPerShopQuery = DB::table('orders')
            ->join('products', 'orders.product_id', 'products.id')
            ->join('shops', 'products.shop_id', 'shops.id')
            ->join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->where('user_profiles.seller_building_id', $user->manager_building_id)
            ->where('orders.order_status', 'Completed')
            ->select('shops.shop_name', DB::raw('SUM(orders.total) as total_sales'), DB::raw('DATE(orders.created_at) as sale_date'))
            ->groupBy('shops.shop_name', 'sale_date')
            ->orderBy('sale_date');

        // Apply date range filter
        if ($request->start_date && $request->end_date) {
            $salesPerShopQuery->whereBetween(DB::raw('DATE(orders.created_at)'), [$request->start_date, $request->end_date]);
        }

        // Apply month filter if provided
        if ($request->month) {
            $salesPerShopQuery->whereMonth('orders.created_at', $request->month);
        }

        $salesPerShop = $salesPerShopQuery->get();

        return view('main.manager.manager',  compact('applications', 'verifiedShops', 'ordersPerShop', 'salesPerShop'));
    }

    public function audit_logs(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $manager = UserProfile::where('id', $userId)->first();

        $logs = Audit::join('user_profiles', 'audits.user_id', 'user_profiles.id')
            ->where('user_profiles.seller_building_id', $manager->manager_building_id)
            ->get();

        return view('main.manager.auditlogs', compact('logs'));
    }

    // My profile and change password
    public function manager_my_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $userProfile = UserProfile::where('id', $userId)->first();

        return view('main.manager.profile', compact('userProfile'));
    }

    public function update_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:user_profiles,username,' . $userId,
                'email' => 'required|email|unique:user_profiles,email,' . $userId,
            ], [
                'first_name.required' => 'First name is required.',
                'last_name.required' => 'Last name is required.',
                'username.required' => 'Username is required.',
                'username.unique' => 'Username is already taken.',
                'email.required' => 'Email is required.',
                'email.email' => 'Invalid email.',
                'email.unique' => 'Email already exists.',
            ]);

            // This block will check if the inputted infos are valid
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $userProfile = UserProfile::where('id', $userId)->first();
            $userProfile->first_name = $request->first_name;
            $userProfile->last_name = $request->last_name;
            $userProfile->email = $request->email;
            $userProfile->username = $request->username;
            $userProfile->updated_at = date('Y-m-d H:i:s');
            $userProfile->save();

            DB::commit();
            return redirect()->route('manager.dashboard')->with('success', 'Profile updated');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function manager_change_password()
    {
        return view('main.manager.password');
    }

    public function update_password(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $credential = Credential::where('user_id', $userId)
            ->where('is_deleted', false)
            ->first();

        if (empty($request->current_password)) {
            return redirect()->back()->with('error', 'Enter Current Password.');
        }

        if (!Hash::check($request->input('current_password'), $credential->password)) {
            return redirect()->back()->with('error', 'The provided current password does not match our records.');
        }

        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/'
                ],
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => 'Current password is required.',
                'new_password.required' => 'New password is required.',
                'new_password.min' => 'New password must be at least 8 characters.',
                'new_password.regex' => 'New password must include at least one uppercase letter and one special character.',
                'confirm_password.required' => 'New password confirmation is required.',
                'confirm_password.same' => 'New password and confirmation do not match.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Mark the old password as deleted
            $credential->is_deleted = true;
            $credential->save();

            // Store the new password
            $newCredential = new Credential();
            $newCredential->user_id = $userId;
            $newCredential->password = Hash::make($request->input('new_password'));
            $newCredential->is_deleted = false;
            $newCredential->created_at = now();
            $newCredential->updated_at = now();
            $newCredential->save();

            DB::commit();
            return redirect()->route('manager.change.password')->with('success', 'Password changed successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    // Creating Concessionare's accounts
    public function concessionaires_account(Request $request)
    {
        $userBuildingId = $request->session()->get('user');

        $user = UserProfile::join('buildings', 'user_profiles.seller_building_id', '=', 'buildings.id')
            ->join('shops', 'user_profiles.id', '=', 'shops.user_id')
            ->join('credentials', 'user_profiles.id', 'credentials.user_id')
            ->select(
                'user_profiles.*',
                'user_profiles.id as user_id',
                'user_profiles.user_type_id as user_type',
                'user_profiles.email as shop_email',
                'user_profiles.contact_num as shop_contact_num',
                'user_profiles.created_at',
                'user_profiles.updated_at as user_date_updated',
                'buildings.building_name as building_name',
                'shops.shop_name as shop_name',
                'shops.status as status',
                'credentials.is_deleted as is_active',
            )
            ->where('seller_building_id', $userBuildingId->manager_building_id)
            ->where(function ($query) {
                $query->where('is_reopen', 1)
                    ->orwhere('user_type_id', 2)
                    ->orwhere('user_type_id', 3);
            })
            ->where('credentials.is_deleted', false)
            ->orderBy('user_profiles.created_at', 'desc')
            ->get();

        return view('main.manager.addConcessionaire', compact('user'));
    }

    public function post_concessionaires_account(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $managerBuilding = $request->session()->get('user');

        $managerBuildingId = $managerBuilding->manager_building_id;

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|email|unique:user_profiles,username',
            ], [
                'username.required' => 'Username is required.',
                'username.email' => 'Must be a valid email address.',
                'username.unique' => 'Username already exists.',
            ]);

            // This block will check if the inputted infos are valid
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $generatedPassword = $this->generatePassword();

            DB::beginTransaction();

            $user = new UserProfile();
            $user->user_type_id = 2;
            $user->first_name = 'Not Available';
            $user->last_name = 'Not Available';
            $user->email = str_replace(' ', '', $request->username);
            $user->username = str_replace(' ', '', $request->username);
            $user->default_pass = $generatedPassword;
            $user->contact_num = 'Not Available';
            $user->email_verified_at = now();
            $user->created_at = now();
            $user->updated_at = now();
            $user->seller_building_id = $managerBuildingId;
            $user->save();

            $canteen = Building::where('id', $managerBuildingId)->first()->building_name;

            // is_reopen column is false by default
            $shop = new Shop();
            $shop->shop_name = 'Not Available';
            $shop->shop_image = 'Not Available';
            $shop->user_id = $user->id;
            $shop->status = 'Unverified';
            $shop->building_id = $user->seller_building_id;
            $shop->created_at = date('Y-m-d H:i:s');
            $shop->updated_at = date('Y-m-d H:i:s');
            $shop->save();

            $credentials = new Credential();
            $credentials->user_id = $user->id;
            $credentials->password = Hash::make($generatedPassword);
            $credentials->is_deleted = 0;
            $credentials->created_at = date('Y-m-d H:i:s');
            $credentials->updated_at = date('Y-m-d H:i:s');
            $credentials->save();

            DB::commit();

            // Send email with credentials
            $this->sendConcessionaireCredentials($user, $generatedPassword, $canteen);

            $description = "";
            $description .= "a new concessionaire account for " . $canteen;
            $commonUtility = new CommonUtilityController();
            $commonUtility->addAuditTrail($userId, 1, $managerBuilding->first_name . ' ' . $managerBuilding->last_name . ' Added ' . $description);

            return redirect()->route('concessionaires.account')->with('success', 'Concessionaire account created.');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('concessionaires.account')->with('error', $e->getMessage());
        }
    }

    private function sendConcessionaireCredentials($concessionaire, $password, $canteen)
    {
        $data = [
            'concessionaire' => $concessionaire,
            'password' => $password,
            'canteen' => $canteen
        ];

        Mail::send('main.manager.concessionaire_credentials', $data, function ($message) use ($concessionaire) {
            $message->to($concessionaire->username)
                ->subject('Your Concessionaire Account Credentials');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }

    private function generatePassword()
    {
        $uppercase = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $lowercase = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $digits = str_shuffle('0123456789');
        $specialChars = str_shuffle('!@#$%^&*()-_+=<>?');

        $password = substr($uppercase, 0, 1) .
            substr($lowercase, 0, 5) .
            substr($digits, 0, 1) .
            substr($specialChars, 0, 1);

        return str_shuffle($password);
    }

    public function edit_button_cons_account(Request $request, $userId)
    {
        $userBuildingId = $request->session()->get('user');

        $user = UserProfile::join('buildings', 'user_profiles.seller_building_id', '=', 'buildings.id')
            ->join('shops', 'user_profiles.id', '=', 'shops.user_id')
            ->select(
                'user_profiles.*',
                'user_profiles.id as user_id',
                'user_profiles.user_type_id as user_type',
                'user_profiles.email as shop_email',
                'user_profiles.contact_num as shop_contact_num',
                'user_profiles.created_at as user_date_created',
                'user_profiles.updated_at as user_date_updated',
                'buildings.building_name as building_name',
                'shops.shop_name as shop_name',
                'shops.status as status',
            )
            ->where('user_profiles.seller_building_id', $userBuildingId->manager_building_id)
            ->orderBy('user_profiles.created_at', 'desc')
            ->get();

        $userData = UserProfile::findOrFail(Crypt::decrypt($userId));

        return view('main.manager.addConcessionaire', compact('user', 'userData'));
    }

    public function edit_cons_account(Request $request, $id)
    {
        try {
            $user = UserProfile::where('id', $id)->firstOrFail();
            DB::beginTransaction();

            // Update the password in the credentials table
            if ($request->has('regenerate_password')) {
                // Generate a new password
                $newPassword = $this->generatePassword();
                $user->default_pass = $newPassword;
                $user->save();

                $credentials = Credential::where('user_id', $id)
                    ->where('is_deleted', false)
                    ->firstOrFail();
                $credentials->is_deleted = true;
                $credentials->save();

                $credentials = new Credential();
                $credentials->user_id = $id;
                $credentials->password = Hash::make($newPassword);
                $credentials->updated_at = now();
                $credentials->save();
            }

            DB::commit();

            // Redirect back with success message and the new password
            return redirect()->route('concessionaires.account')->with('success', 'Password reset successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function delete_concessionaires_account($id)
    {
        try {
            $shop = UserProfile::findOrFail($id);
            $shop->delete();
            return redirect()->route('concessionaires.account')->with('success', 'Concessionaire account deleted');
        } catch (Exception $e) {
            return redirect()->route('concessionaires.account')->with('error', $e->getMessage());
        }
    }

    // Approving Concessionare's applications
    public function shops_applications(Request $request)
    {
        $manager = $request->session()->get('user');

        $application = Permit::join('shops', 'permits.shop_id', '=', 'shops.id')
            ->select(
                'permits.*',
                'permits.id as permit_id',
                'permits.created_at as date_submitted',
                'permits.status as application_status',
                'shops.shop_name',
            )
            ->where('shops.building_id', $manager->manager_building_id)
            ->where('permits.is_rejected', false)
            ->where('permits.status', 'Pending')
            ->orderBy('permits.created_at', 'desc')
            ->get();

        return view('main.manager.applications', compact('application'));
    }

    public function approve_shops_application(Request $request, $id)
    {
        $userId = $request->session()->get('loginId');

        if(!$userId) {
            return redirect()->route('user.logout');
        }

        $manager = UserProfile::where('id', $userId)->first();
        $canteen = Building::where('id', $manager->manager_building_id)->first()->building_name;

        try {
            DB::beginTransaction();

            // Find the permit by ID
            $permit = Permit::find($id);

            if ($permit) {
                // Retrieve the shop model using the shop_id from the permit
                $shop = Shop::where('id', $permit->shop_id)->first();

                if ($shop) {
                    // Update the role id to 'Seller'
                    $user = UserProfile::where('id', $shop->user_id)->first();
                    $user->user_type_id = 3;
                    $user->save();

                    // Update the shop status to 'Verified'
                    $shop->status = 'Verified';
                    $shop->is_reopen = false;
                    $shop->save();

                    // Update the permit status to 'Approved'
                    $permit->status = 'Approved';
                    $permit->is_rejected = 0;
                    $permit->save();

                    // Send email notification
                    $this->sendApplicationStatus($user, $shop, 'Approved');

                    DB::commit();

                    $description = "";
                    $description .= "a concessionaire's account for " . $canteen;
                    $commonUtility = new CommonUtilityController();
                    $commonUtility->addAuditTrail($userId, 2, $manager->first_name . ' ' . $manager->last_name . ' Verifies ' . $description);        

                    return redirect()->route('shops.applications')->with('success', 'Application approved successfully.');
                } else {
                    return redirect()->route('shops.applications')->with('error', 'Shop not found.');
                }
            } else {
                DB::rollBack();
                return redirect()->route('shops.applications')->with('error', 'Application not found.');
            }
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function reject_shops_application(Request $request, $id)
    {
        $userId = $request->session()->get('loginId');

        if(!$userId) {
            return redirect()->route('user.logout');
        }

        $manager = UserProfile::where('id', $userId)->first();
        $canteen = Building::where('id', $manager->manager_building_id)->first()->building_name;

        try {
            // Validate the feedback input
            $request->validate([
                'feedback' => 'required|string|max:255',
                'rejected_files' => 'required|array',
            ]);

            DB::beginTransaction();

            // Find the permit by ID
            $permit = Permit::find($id);

            if ($permit) {
                $shop = Shop::where('id', $permit->shop_id)->first();

                if ($shop) {
                    // Update the shop and permit statuses
                    $shop->status = 'Unverified';
                    $shop->save();

                    $permit->status = 'Rejected';
                    $permit->is_rejected = 1;

                    // Store the rejected files in the feedback
                    $rejectedFiles = $request->input('rejected_files');
                    $permit->rejected_files = implode(", ", $rejectedFiles);
                    $permit->feedback = $request->feedback;
                    $permit->save();

                    // Send email notification
                    $user = UserProfile::where('id', $shop->user_id)->first();

                    $this->sendApplicationStatus($user, $shop, 'Rejected', $request->feedback, $rejectedFiles);

                    DB::commit();

                    $description = "";
                    $description .= "a concessionaire's application ";
                    $commonUtility = new CommonUtilityController();
                    $commonUtility->addAuditTrail($userId, 2, $manager->first_name . ' ' . $manager->last_name . ' Rejects ' . $description);

                    return redirect()->route('shops.applications')->with('success', 'Application rejected successfully.');
                } else {
                    return redirect()->route('shops.applications')->with('error', 'Shop not found.');
                }
            } else {
                DB::rollBack();
                return redirect()->route('shops.applications')->with('error', 'Application not found.');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    private function sendApplicationStatus($user, $shop, $status, $feedback = null, $rejectedFiles = null)
    {
        $data = [
            'user' => $user,
            'shop' => $shop,
            'status' => $status,
            'feedback' => $feedback,
            'files' => $rejectedFiles
        ];

        Mail::send('main.manager.application_status_email', $data, function ($message) use ($user, $status) {
            $message->to($user->email)
                ->subject("Your Shop Application has been {$status}");
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
    }

    public function applications_history(Request $request)
    {
        $manager = $request->session()->get('user');

        $application = Permit::join('shops', 'permits.shop_id', '=', 'shops.id')
            ->select(
                'permits.*',
                'permits.created_at as date_submitted',
                'permits.updated_at as date_updated',
                'permits.status as application_status',
                'shops.shop_name',
            )
            ->where('shops.building_id', $manager->manager_building_id)
            ->where(function ($query) {
                $query->orWhere('permits.status', 'Rejected')
                    ->orWhere('permits.status', 'Approved');
            })
            ->orderBy('permits.updated_at', 'desc')
            ->get();

        $shopApplication = $application->groupBy('shop_id');

        return view('main.manager.applicationHistory', compact('application', 'shopApplication'));
    }
}
