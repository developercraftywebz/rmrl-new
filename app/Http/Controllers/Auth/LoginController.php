<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserTypes;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated($request, $user){
   
        if($user->role_id == UserTypes::User){
            $this->redirectTo = RouteServiceProvider::USER_DASHBOARD;
        }
        if($user->role_id == UserTypes::Admin){
            $this->redirectTo = RouteServiceProvider::ADMIN_DASHBOARD;
        }
        return redirect($this->redirectTo);
    }

    // public function login(Request $request)
    // {
    //     $this->validateLogin($request);

    //     // If the class is using the ThrottlesLogins trait, we can automatically throttle
    //     // the login attempts for this application. We'll key this by the username and
    //     // the IP address of the client making these requests into this application.
    //     if (
    //         method_exists($this, 'hasTooManyLoginAttempts') &&
    //         $this->hasTooManyLoginAttempts($request)
    //     ) {
    //         $this->fireLockoutEvent($request);

    //         return $this->sendLockoutResponse($request);
    //     }

    //     if (User::where('email', $request->email)->where('status', 0)->first()) {
    //         return Redirect::back()->with(['flash_error' => "You account is not verified, Please contact administrator!"]);
    //     }

    //     if (User::where('email', $request->email)->whereIn('role_id', [UserTypes::Admin, UserTypes::Moderator, UserTypes::User])->first() == null) {
    //         return Redirect::back()->with(['flash_error' => "You account is not verified"]);
    //     }

    //     if ($this->attemptLogin($request)) {
    //         if ($request->hasSession()) {
    //             $request->session()->put('auth.password_confirmed_at', time());
    //         }
    //         return $this->sendLoginResponse($request);
    //     }
    //     // If the login attempt was unsuccessful we will increment the number of attempts
    //     // to login and redirect the user back to the login form. Of course, when this
    //     // user surpasses their maximum number of attempts they will get locked out.
    //     $this->incrementLoginAttempts($request);
    //     return $this->sendFailedLoginResponse($request);
    // }

    public function logout(Request $request)
{
    Auth::logout(); // This will invalidate the user's session

    // Optionally, you can flush the session data
    $request->session()->flush();

    // Optionally, regenerate the session ID to prevent session fixation attacks
    $request->session()->regenerate();

    // Redirect the user to the login page or any other desired page
    return Redirect::to('/login');
}
    
}
