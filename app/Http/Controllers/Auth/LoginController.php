<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use PragmaRX\Google2FALaravel\Google2FA;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('auth.login');
    }

    public function authenticated(Request $request, $user){
        $google2FA = app('pragmarx.google2fa');

            if($request->session()->has('2FA_passed')) {
                $request->session()->forget('2FA_passed');
            }

            $request->session()->put('2FA:user:id', $user->id);
            $request->session()->put('2FA:auth:attempt', true);
            $request->session()->put('2FA:auth:remember', $request->has('remember'));

            if ($user->google2fa_secret != null) {
                // If the user has a Google 2FA secret, redirect to 2FA page
                $request->session()->put('2FA:user:activated', true);
            } 

            return redirect()->route('2FA')->with('google2fa_secret', false);
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request), 3 
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit(
            $this->throttleKey($request)
        );
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('username')) . '|' . $request->ip();
    }

    protected function clearLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        RateLimiter::clear($key);
    }
    
    public function login(Request $request)
    {
    
        // Validate login credentials
        $validatedData = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|min:8|max:255',
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt($validatedData)) {
            // If authentication is successful, reset login attempts
            $this->clearLoginAttempts($request);
            // Redirect to the intended location
            return $this->authenticated($request, Auth::user());
        }
    
        // Increment failed login attempts
        $this->incrementLoginAttempts($request);
    
        // If login attempts exceed the threshold, lock the user out
        if ($this->hasTooManyLoginAttempts($request)) {
            event(new Lockout($request));
        }

        // Check if the user is locked out due to too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            // If locked out, show the captcha field
            return view('auth.login')->withErrors(['captcha' => 'Please solve the captcha.', 'login' => 'Invalid username or password.']);
        }
    
        // If the user is not locked out, show the login form with errors
        return view('auth.login')->withErrors(['login' => 'Invalid username or password.']);
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getGoogle2faSecretAttribute($value)
    {
        return decrypt($value);
    }

}
