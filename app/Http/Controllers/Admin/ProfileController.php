<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Helpers\Media;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $validation = [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            if (!$request->password) {
                unset($validation['password']);
            }

            $request->validate($validation);

            $user = Auth::user();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->profile_picture = $request->profile_picture;

            $user->save();

            if ($request->has('profile_picture')) {
                $updatedUrl = Media::profileAvatar($request->profile_picture);
                $user->profile_picture = $updatedUrl;
                $user->save();
            }

            if ($user->save()) {
                return Redirect::back()->with(['flash_success' => "Congratulations!, Profile details are updated."]);
            }

            return Redirect::back()->with(['flash_error' => "Oops!, Something went wrong."]);
        }

        return view('admin.profile.index');
    }
}
