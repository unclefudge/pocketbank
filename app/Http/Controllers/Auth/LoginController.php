<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Get user record
        $user = User::where('username', $request->get('username'))->first();

        // Check Condition Mobile No. Found or Not
        if ($request->get('username') != $user->username) {
            \Session::put('errors', 'Your login not match in our system..!!');

            return back();
        }

        // Set Auth Details
        Auth::login($user);

        // Redirect home page
        if (Auth::user()->id < 3)
            return view('home');

        return redirect(Auth::user()->username);
    }

}
