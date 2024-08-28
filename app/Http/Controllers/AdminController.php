<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Credential;
use App\Models\UserProfile;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends Controller
{
    public function admin_dashboard()
    {
        return view('main.admin.admin');
    }

    public function aduit_logs()
    {
        return view('main.admin.auditlogs');
    }

    public function buyers_account()
    {
        $user = UserProfile::where('user_type_id', 1)->orderBy('created_at', 'desc')->get();
        return view('main.admin.buyersaccount', compact('user'));
    }

    //   My profile and change password
    public function admin_my_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $userProfile = UserProfile::where('id', $userId)->first();

        return view('main.admin.profile', compact('userProfile'));
    }

    public function update_profile(Request $request)
    {
        $userId = $request->session()->get('loginId');

        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'required|unique:user_profiles,username,' . $userId,
                    'email' => 'required|email|unique:user_profiles,email,' . $userId,
                ],
                [
                    'first_name.required' => 'First name is required.',
                    'last_name.required' => 'Last name is required.',
                    'username.required' => 'Username is required.',
                    'username.unique' => 'Username is already taken.',
                    'email.required' => 'Email is required.',
                    'email.email' => 'Invalid email.',
                    'email.unique' => 'Email already exists.',
                ]
            );

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
            return redirect()->route('admin.dashboard')->with('success', 'Profile updated');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function admin_change_password()
    {
        return view('main.admin.password');
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
            return redirect()->route('admin.change.password')->with('success', 'Password changed successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    //   Canteen Control Functions
    public function manage_building(Request $request)
    {
        $buildings = Building::all();
        return view('main.admin.adminAddBuilding', compact('buildings'));
    }

    public function post_manage_building(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'building_name' => 'required|unique:buildings,building_name',
                'building_image' => 'nullable|file|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:51200',
                'building_description' => 'required|max:255',
            ], [
                'building_name.required' => 'Please enter canteen name',
                'building_name.unique' => 'Canteen name already exist',
                'building_image.required' => 'Please select canteen image',
                'building_image.file' => 'Please select a valid image file',
                'building_description.required' => 'Please enter canteen description',
                'building_description.max' => 'Canteen description must not be greater than 255 characters',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            // Handle image upload if exists
            $image = null;
            if ($request->hasFile('building_image')) {
                $image = time() . '_' . $request->building_name . '_' . $request->building_image->getClientOriginalName();
                $request->file('building_image')->storeAs('canteen', $image, 'public');
            }

            $building = new Building();
            $building->building_name = $request->building_name;
            $building->building_image = $image;
            $building->building_description = $request->building_description;
            $building->created_at = date('Y-m-d H:i:s');
            $building->updated_at = date('Y-m-d H:i:s');
            $building->save();

            DB::commit();
            return redirect()->back()->with('success', 'Canteen added successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function edit_button_building($id)
    {
        $buildings = Building::all();
        $buildingData = Building::findOrFail($id);
        return view('main.admin.adminAddBuilding', compact('buildingData', 'buildings'));
    }

    public function edit_building(Request $request, $id, $building_name)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'building_name' => 'required|string|max:255',
                'building_image' => 'nullable|file|mimes:jpg,jpeg,png,JPG,JPEG,PNG|max:5000',
                'building_description' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $building = Building::where('id', $id)
                ->where(DB::raw('LOWER(REPLACE(building_name, " ", "-"))'), strtolower($building_name))
                ->firstOrFail();

            if ($request->hasFile('building_image')) {
                // Delete old image if exists
                if ($building->building_image) {
                    Storage::disk('public')->delete('canteen/' . $building->building_image);
                }

                // Store new image
                $image = time() . '_' . $request->building_name . '_' . $request->building_image->getClientOriginalName();
                $request->file('building_image')->storeAs('canteen', $image, 'public');
                $building->building_image = $image;
            }

            $building->building_name = $request->building_name;
            $building->building_description = $request->building_description;
            $building->save();

            DB::commit();
            return redirect()->route('manage.building')->with('success', 'Canteen updated successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function delete_building($id)
    {
        try {
            $building = Building::findOrFail($id);
            $building->delete();
            return redirect()->route('manage.building')->with('success', 'Canteen deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('manage.building')->withErrors($e->getMessage());
        }
    }

    //   Manager's Accounts Functions
    public function manager_account()
    {
        $user = UserProfile::join('buildings', 'user_profiles.manager_building_id', '=', 'buildings.id')
            ->select(
                'user_profiles.*',
                'user_profiles.id as user_id',
                'user_profiles.user_type_id as user_type',
                'user_profiles.created_at as user_date_created',
                'user_profiles.updated_at as user_date_updated',
                'buildings.*',
                'buildings.id as building_id',
            )
            ->where('user_type_id', 5)
            ->orderBy('user_profiles.created_at', 'desc')
            ->get();
        $buildings = Building::all();
        return view('main.admin.adminAddManager', compact('user', 'buildings'));
    }

    public function post_manager_account(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:user_profiles,username',
                'building_id' => 'required',
            ], [
                'first_name.required' => 'First name is required.',
                'last_name.required' => 'Last name is required.',
                'username.required' => 'Username is required.',
                'username.unique' => 'Username already exists.',
                'building_id.required' => 'Building is required.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $generatedPassword = $this->generatePassword();

            DB::beginTransaction();

            $user = new UserProfile();
            $user->user_type_id = 5;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = 'Not Available';
            $user->username = $request->username;
            $user->default_pass = $generatedPassword;
            $user->contact_num = 'Not Available';
            $user->created_at = now();
            $user->updated_at = now();
            $user->manager_building_id = $request->building_id;
            $user->save();

            $credentials = new Credential();
            $credentials->user_id = $user->id;
            $credentials->password = Hash::make($generatedPassword); // Store hashed password
            $credentials->is_deleted = 0;
            $credentials->created_at = now();
            $credentials->updated_at = now();
            $credentials->save();

            DB::commit();

            // Redirect back to the manager account list with the success message and the generated password
            return redirect()->route('manager.account')->with('success', 'Manager account created successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
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

    public function edit_button_manager_account($id)
    {
        $user = UserProfile::join('buildings', 'user_profiles.manager_building_id', '=', 'buildings.id')
            ->select(
                'user_profiles.*',
                'user_profiles.id as user_id',
                'user_profiles.user_type_id as user_type',
                'user_profiles.created_at as user_date_created',
                'user_profiles.updated_at as user_date_updated',
                'buildings.*',
                'buildings.id as building_id',
            )
            ->where('user_profiles.user_type_id', 5)
            ->orderBy('user_profiles.created_at', 'desc')
            ->get();

        $userData = UserProfile::findOrFail($id);

        $buildings = Building::all();

        return view('main.admin.adminAddManager', compact('user', 'userData', 'buildings'));
    }

    public function edit_manager_account(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'building_id' => 'required',
            ], [
                'first_name.required' => 'First name is required.',
                'last_name.required' => 'Last name is required.',
                'building_id.required' => 'Building is required.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();

            $user = UserProfile::findOrFail($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->manager_building_id = $request->building_id;

            // Check if a new password should be generated
            if ($request->has('regenerate_password')) {
                $generatedPassword = $this->generatePassword();
                $user->default_pass = $generatedPassword;
                $user->save();

                // Replace the old password
                $credentials = Credential::where('user_id', $user->id)
                    ->where('is_deleted', false)
                    ->first();
                $credentials->is_deleted = true;
                $credentials->save();

                // Creating a new password
                $credentials = new Credential();
                $credentials->user_id = $user->id;
                $credentials->password = Hash::make($generatedPassword);
                $credentials->is_deleted = false;
                $credentials->created_at = now();
                $credentials->updated_at = now();
                $credentials->save();
            }

            DB::commit();
            return redirect()->route('manager.account')->with('success', 'User updated successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function delete_manager($id)
    {
        try {
            $user = UserProfile::findOrFail($id);
            $user->delete();
            return redirect()->route('manager.account')->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('manager.account')->with('error', $e->getMessage());
        }
    }
}
