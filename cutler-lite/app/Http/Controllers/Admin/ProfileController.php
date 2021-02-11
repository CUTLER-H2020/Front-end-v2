<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePasswordView()
    {
        return view('admin.profile.change-pass');
    }

    public function changePasswordUpdate(ChangePasswordRequest  $request)
    {
        $user = User::find(Auth::id());
        if (Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            session_success(trans('translation.general.password-changed'));
            return redirect()->back();
        }
    }
}
