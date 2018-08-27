<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;
use Session;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('auth/login');
    }

    public function post(Request $request) {
        $credentials = $request->only('username','password');
        // $credentials = $credentials + ['status' => 'active'];
        $credentials = array_merge($credentials, ['status' => 'active']);

        $data = [];
        if(Auth::guard('admin')->attempt($credentials)) {
            // return redirect()->intended('dashboard');
            $data['type'] = 'success';
            $data['message'] = 'Loging-in in a few seconds';

        } else {
            // return redirect()->intended('login');
            $data['type'] = 'error';
            $data['message'] = 'Username or Password Invalid';
        }
        return $data;
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
