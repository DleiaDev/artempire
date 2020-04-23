<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;
use App\Social;
use App\Lib\Imgur as Imgur;
use App\Lib\Image;

class AccountController extends Controller
{
    public function updateGeneral(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
          'fullName' => 'required',
          'email' => 'required|email|unique:users,email,'.$user->id,
          'username' => 'required|min:3|unique:users,username,'.$user->id,
        ]);

        $user->update($request->all());

        return $request->all();
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
          'currentPassword' => 'required',
          'newPassword' => 'required|confirmed|min:6',
          'newPassword_confirmation' => 'required'
        ]);

        $errors = (object)[];

        if (!Hash::check($request->currentPassword, $user->password)) {
          $errors->currentPassword = ['Incorrect current password.'];
          return response()->json(['message' => 'The given data was invalid.', 'errors' => $errors], 422);
        }

        if (strcmp($request->currentPassword, $request->newPassword) == 0) {
          $errors->newPassword = ['New password and current password cannot be the same.'];
          return response()->json(['message' => 'The given data was invalid.', 'errors' => $errors], 422);
        }

        $user->password = bcrypt($request->newPassword);

        $user->save();
    }

    public function updateSocialLinks(Request $request)
    {
        $socialLinks = Social::where('user_id', auth()->user()->id)->first();
        $socialLinks->update($request->all());
        $socialLinks->save();
    }

    public function changeProfile(Request $request)
    {
        if (!$request->hasFile('profile')) return response('Error', 422);

        $this->validate($request, [
          'profile' => 'required|mimes:png,jpeg,jpg,svg|max:2048|dimensions:min_width=400,min_height=400'
        ]);

        $user = auth()->user();

        $imageLink = Image::upload($request->profile, 'profiles');

        if ($user->profile != Image::$defaultProfile)
          Image::delete($user->profile, 'profiles');

        $user->update(['profile' => $imageLink]);

        return response()->json([
          'profile' => $imageLink
        ]);
    }

    public function changeBackground(Request $request)
    {
        if (!$request->hasFile('background')) return response('Error', 422);

        $this->validate($request, [
          'background' => 'required|mimes:png,jpeg,jpg,svg|max:2048|dimensions:min_width=1000,min_height=500'
        ]);

        $user = auth()->user();

        $imageLink = Image::upload($request->background, 'backgrounds');

        if ($user->background != Image::$defaultBackground)
          Image::delete($user->background, 'backgrounds');

        $user->update(['background' => $imageLink]);

        return response()->json([
          'background' => $imageLink
        ]);
    }
}
