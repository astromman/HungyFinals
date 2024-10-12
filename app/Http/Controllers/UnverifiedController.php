<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Models\Permit;
use App\Models\Shop;
use App\Models\UserProfile;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UnverifiedController extends Controller
{
    public function resubmission_form(Request $request)
    {
        $userId = $request->session()->get('loginId');

        $shopDetails = Shop::join('user_profiles', 'shops.user_id', 'user_profiles.id')
            ->select(
                'shops.*',
                'user_profiles.email',
                'user_profiles.contact_num',
            )
            ->where('user_id', $userId)
            ->first();

        $applicationId = $shopDetails ? Permit::where('shop_id', $shopDetails->id)
            ->orderByDesc('created_at')
            ->first() : null;

        if ($applicationId && $applicationId->status == 'Approved') {
            $user = UserProfile::find($userId);

            // Automatically log the user in
            $request->session()->put('user', $user);
            $request->session()->put('loginId', $user->id);
            $request->session()->put('username', $user->username);
            $request->session()->put('email', $user->email);

            $isNewShop = false;
            if ($shopDetails && Carbon::parse($shopDetails->created_at)->gt(Carbon::now()->subMinutes(10))) {
                session()->put('isNewShop', true);
                $isNewShop = true;
            } else {
                session()->put('isNewShop', false);
            }

            // Redirect the user based on their user type
            switch ($user->user_type_id) {
                case 3:
                    return redirect()->route('seller.dashboard')->with('success', 'Registration successful! You are now logged in.');
                default:
                    return redirect()->route('login.form')->with('error', 'Unauthorized Access!');
            }
        }

        return view('main.unverified.unverified', compact('applicationId', 'shopDetails'));
    }

    public function submit_application(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $shopId = Shop::where('user_id', $userId)->value('id');

        try {
            $validator = Validator::make(request()->all(), [
                'shop_name' => 'required|unique:shops,shop_name',
                'contact_num' => 'required|numeric|digits:11|starts_with:09|unique:user_profiles,contact_num',
                'qr_image' => 'required|image|mimes:jpeg,png|max:51200',
                'mayors' => 'required|file|mimes:jpeg,png,pdf|max:51200',
                'bir' => 'required|file|mimes:jpeg,png,pdf,webp|max:51200',
                'dti' => 'required|file|mimes:jpeg,png,pdf,webp|max:51200',
                'contract' => 'required|file|mimes:jpeg,png,pdf,webp|max:51200',
                'sanitary' => 'required|file|mimes:jpeg,png,pdf,webp|max:51200',
            ], [
                'shop_name.required' => 'Please enter shop name',
                'shop_name.unique' => 'Shop name already exists',
                'email.required' => 'Please enter email',
                'email.email' => 'Invalid email',
                'email.unique' => 'Email already exists',
                'contact_num.required' => 'Please enter contact number',
                'contact_num.min' => 'Invalid Phone number',
                'contact_num.max' => 'Invalid Phone number',
                'contact_num.starts_with' => 'Invalid Phone number',
                'contact_num.unique' => 'Phone number already used',
                'qr_image.required' => 'Please upload QR image',
                'mayors.required' => 'Please upload mayors permit',
                'mayors.file' => 'Please upload mayors permit',
                'mayors.mimes' => 'Please upload mayors permit in jpeg, png or pdf',
                'mayors.max' => 'Please upload mayors permit less than 50MB',
                'bir.required' => 'Please upload BIR',
                'bir.file' => 'Please upload BIR',
                'bir.mimes' => 'Please upload BIR in jpeg, png or pdf',
                'bir.max' => 'Please upload BIR less than 50MB',
                'dti.required' => 'Please upload DTI ',
                'dti.file' => 'Please upload DTI ',
                'dti.mimes' => 'Please upload DTI in jpeg, png or pdf',
                'dti.max' => 'Please upload DTI  less than 50MB',
                'contract.required' => 'Please upload AdU contract',
                'contract.file' => 'Please upload contract',
                'contract.mimes' => 'Please upload contract in jpeg, png or pdf',
                'contract.max' => 'Please upload contract less than 50MB',
                'sanitary.required' => 'Please upload the sanitary permit',
                'sanitary.mimes' => 'Please upload the sanitary permit in jpeg, png, or pdf format',
                'sanitary.max' => 'Please upload the sanitary permit less than 50MB',
            ]);

            if ($validator->fails()) {
                dd($request->file('sanitary'));
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $qrImage = 'qr-payment_' . time() . '_' . $request->qr_iamge . '_' . $request->qr_image->getClientOriginalName();
            $request->file('qr_image')->storeAs('shop', $qrImage, 'public');

            $mayorFile = 'mayors-permit_' . time() . '_' . $request->shop_name . '_' . $request->mayors->getClientOriginalName();
            $request->file('mayors')->storeAs('permits', $mayorFile, 'public');

            $birFile = 'bir_' . time() . '_' . $request->shop_name . '_' . $request->bir->getClientOriginalName();
            $request->file('bir')->storeAs('permits', $birFile, 'public');

            $dtiFile = 'dti_' . time() . '_' . $request->shop_name . '_' . $request->dti->getClientOriginalName();
            $request->file('dti')->storeAs('permits', $dtiFile, 'public');

            $contractFile = 'adu-contract_' . time() . '_' . $request->shop_name . '_' . $request->contract->getClientOriginalName();
            $request->file('contract')->storeAs('permits', $contractFile, 'public');

            $sanitaryFile = 'sanitary_' . time() . '_' . $request->shop_name . '_' . $request->sanitary->getClientOriginalName();
            $request->file('sanitary')->storeAs('permits', $sanitaryFile, 'public');

            DB::beginTransaction();

            $user = UserProfile::findOrFail($userId);
            $user->contact_num = $request->contact_num;
            $user->updated_at = now();
            $user->save();

            $shop = Shop::findOrFail($shopId);
            $shop->shop_name = $request->shop_name;
            $shop->shop_qr = $qrImage;
            $shop->status = 'Processing';
            $shop->updated_at = now();
            $shop->save();

            $permit = new Permit();
            $permit->mayors = $mayorFile;
            $permit->bir = $birFile;
            $permit->dti = $dtiFile;
            $permit->sanitary = $sanitaryFile;
            $permit->contract = $contractFile;
            $permit->shop_id = $shop->id;
            $permit->status = 'Pending';
            $permit->is_rejected = false;
            $permit->created_at = now();
            $permit->updated_at = now();
            $permit->save();

            DB::commit();
            return redirect()->route('resubmission.form')->with('success', 'Resubmission Success');
        } catch (QueryException $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (FileException $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'File upload error: ' . $e->getMessage());
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function resubmit_application(Request $request)
    {
        $userId = $request->session()->get('loginId');
        $shopId = Shop::where('user_id', $userId)->value('id');
        $shopDetails = Shop::where('id', $shopId)->first();

        try {
            // Fetch the existing permit details
            $oldPermit = Permit::where('shop_id', $shopId)
                ->where('status', 'Rejected')
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$oldPermit || $oldPermit->status !== 'Rejected') {
                return redirect()->back()->with('error', 'Invalid request.');
            }

            // Determine which files need to be resubmitted based on the rejected_files column
            $rejectedFiles = [];
            if (str_contains($oldPermit->rejected_files, 'mayor\'s')) {
                $rejectedFiles[] = 'mayors';
            }
            if (str_contains($oldPermit->rejected_files, 'bir')) {
                $rejectedFiles[] = 'bir';
            }
            if (str_contains($oldPermit->rejected_files, 'dti')) {
                $rejectedFiles[] = 'dti';
            }
            if (str_contains($oldPermit->rejected_files, 'AdU contract')) {
                $rejectedFiles[] = 'contract';
            }
            if (str_contains($oldPermit->rejected_files, 'sanitary')) {
                $rejectedFiles[] = 'sanitary';
            }

            // Validation rules only for rejected files
            $validationRules = [];

            // Only apply "required" to the files that were rejected
            if (in_array('mayors', $rejectedFiles)) {
                $validationRules['mayors'] = 'required|file|mimes:jpeg,png,pdf|max:51200';
            } else {
                $validationRules['mayors'] = 'nullable';
            }

            if (in_array('bir', $rejectedFiles)) {
                $validationRules['bir'] = 'required|file|mimes:jpeg,png,pdf|max:51200';
            } else {
                $validationRules['bir'] = 'nullable';
            }

            if (in_array('dti', $rejectedFiles)) {
                $validationRules['dti'] = 'required|file|mimes:jpeg,png,pdf|max:51200';
            } else {
                $validationRules['dti'] = 'nullable';
            }

            if (in_array('contract', $rejectedFiles)) {
                $validationRules['contract'] = 'required|file|mimes:jpeg,png,pdf|max:51200';
            } else {
                $validationRules['contract'] = 'nullable';
            }

            if (in_array('sanitary', $rejectedFiles)) {
                $validationRules['sanitary'] = 'required|file|mimes:jpeg,png,pdf|max:51200';
            } else {
                $validationRules['sanitary'] = 'nullable';
            }

            // Perform validation for only the rejected files
            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create new permit object to store the files
            $newPermit = new Permit;

            // Copy old files for non-rejected fields and update rejected files
            if (in_array('mayors', $rejectedFiles)) {
                $mayorFile = 'mayor\'s-permit_' . time() . '_' . $shopDetails->shop_name . '_' . $request->file('mayors')->getClientOriginalName();
                $request->file('mayors')->storeAs('permits', $mayorFile, 'public');
                $newPermit->mayors = $mayorFile;
            } else {
                $newPermit->mayors = $oldPermit->mayors; // Copy the old file
            }

            if (in_array('bir', $rejectedFiles)) {
                $birFile = 'bir_' . time() . '_' . $shopDetails->shop_name . '_' . $request->file('bir')->getClientOriginalName();
                $request->file('bir')->storeAs('permits', $birFile, 'public');
                $newPermit->bir = $birFile;
            } else {
                $newPermit->bir = $oldPermit->bir; // Copy the old file
            }

            if (in_array('dti', $rejectedFiles)) {
                $dtiFile = 'dti_' . time() . '_' . $shopDetails->shop_name . '_' . $request->file('dti')->getClientOriginalName();
                $request->file('dti')->storeAs('permits', $dtiFile, 'public');
                $newPermit->dti = $dtiFile;
            } else {
                $newPermit->dti = $oldPermit->dti; // Copy the old file
            }

            if (in_array('contract', $rejectedFiles)) {
                $contractFile = 'adu-contract_' . time() . '_' . $shopDetails->shop_name . '_' . $request->file('contract')->getClientOriginalName();
                $request->file('contract')->storeAs('permits', $contractFile, 'public');
                $newPermit->contract = $contractFile;
            } else {
                $newPermit->contract = $oldPermit->contract; // Copy the old file
            }

            if (in_array('sanitary', $rejectedFiles)) {
                $sanitaryFile = 'sanitary_' . time() . '_' . $shopDetails->shop_name . '_' . $request->file('sanitary')->getClientOriginalName();
                $request->file('sanitary')->storeAs('permits', $sanitaryFile, 'public');
                $newPermit->sanitary = $sanitaryFile;
            } else {
                $newPermit->sanitary = $oldPermit->sanitary;
            }

            // Save new permit with updated and copied files
            $newPermit->shop_id = $shopId;
            $newPermit->status = 'Pending';
            $newPermit->is_rejected = false;
            $newPermit->rejected_files = null;
            $newPermit->created_at = now();
            $newPermit->updated_at = now();
            $newPermit->save();

            // Update the shop status to 'Processing'
            $shopDetails->status = 'Processing';
            $shopDetails->updated_at = now();
            $shopDetails->save();

            DB::commit();

            return redirect()->route('resubmission.form')->with('success', 'Resubmission Success');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function unv_change_password()
    {
        return view('main.unverified.password');
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
            return redirect()->route('unv.change.password')->with('success', 'Password changed successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
