<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class TwoFAController extends Controller
{
    //

    public function index(){
        return view("auth.activate_2fa");
    }

    public function show(Request $request){

        // initialize 2fa class
        $google2fa = app('pragmarx.google2fa');

        // generate secret key for 2fa 
        $secret_key = $google2fa->generateSecretKey();

        // get user data
        $user = Auth::user();

        $request->session()->put('google2fa_secret', $secret_key);

        $user_id = Auth::user()->id;
        User::where('id', $user_id)->update(
            ['google2fa_secret'=> $secret_key]
        );

        // generate QR image with a larger size (e.g., 500)
        $qrImg = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret_key,
            400 // specify the size parameter directly as an integer
        );

        // dd($request->session()->get('google2fa_secret'), $secret_key);

        return view('auth.activate_2fa', ['qrImg' => $qrImg, 'secret_key' => $secret_key]);

    }

    public function verify(Request $request)
    {        
        $validatedData = $request->validate([
            'otp_num' => 'required|string'
        ]);

        // dd($request->session()->get('google2fa_secret'));

        // Retrieve session data
        $user_id = $request->session()->get('2FA:user:id');
        // $secret_key = $request->session()->get('google2fa_secret');
        $secret_key = Auth::user()->google2fa_secret;
        // $otp_secret = $google2fa->getCurrentOtp($secret_key);

        // Check if session data is present
        if (!$secret_key) {
            dd($request->session()->get('google2fa_secret'), $secret_key);
            return redirect()->route('login');
        }

        // Verify OTP
        $google2fa = app('pragmarx.google2fa');

        if (!$google2fa->verifyKey($secret_key, $validatedData['otp_num'])) {
            // dd($secret_key, $validatedData['otp_num']);
            // dd('otp gagal');
            return redirect()->back()->withErrors([
                'otp_num' => __('The one-time password is invalid.'),
            ]);
        }

        // Clear session data if OTP is valid
        $request->session()->remove('2FA:user:id');
        $request->session()->remove('google2fa_secret');

        // dd('otp berhasil');

        // Redirect to the intended location or perform further actions
        return redirect()->intended('/home');
    }


    // public function verify(Request $request)
    // {        
    //     $request->validate([
    //         'otp_num' => 'required|string'
    //     ]);
    
    //     // Retrieve session data
    //     $user_id = $request->session()->get('2FA:user:id');
    //     $remember = $request->session()->get('2FA:auth:remember', false);
    //     $attempt = $request->session()->get('2FA:auth:attempt', false);
    
    //     // Check if session data is present
    //     if(!$user_id || !$attempt){
    //         return redirect()->route('login');
    //     }
    
    //     // Retrieve user and check if 2FA is enabled
    //     $user = User::find($user_id);
    
    //     if (!$user || !$user->uses_two_factor_auth) {
    //         return redirect()->route('login');
    //     }
    
    //     // Verify OTP
    //     $google2fa = app('pragmarx.google2fa');
    //     $otp_secret = $request->session()->get('google2fa_secret');
    
    //     if (!$google2fa->verifyKey($otp_secret, $request->otp_num)) {
    //         return redirect()->back()->withErrors([
    //             'otp_num' => __('The one-time password is invalid.'),
    //         ]);
    //     }
    
    //     // Authentication attempt
    //     $guard = config('auth.defaults.guard');
    //     $credentials = [$user->getAuthIdentifierName() => $user->getAuthIdentifier(), 'password' => $user->getAuthPassword()];
    
    //     if($remember){
    //         $guard = config('auth.defaults.remember_me_guard', $guard);
    //     }
    
    //     if($attempt){
    //         $guard = config('auth.defaults.attempt_guard', $guard);
    //     }
    
    //     if(Auth::guard($guard)->attempt($credentials, $remember)){
    //         // Clear session data
    //         $request->session()->remove('2FA:user:id');
    //         $request->session()->remove('2FA:auth:remember');
    //         $request->session()->remove('2FA:auth:attempt');
    //         $request->session()->remove('google2fa_secret');
            
    //         // Set Google2FA secret attribute
    //         $this->setGoogle2faSecretAttribute($user, $otp_secret);
        
    //         return redirect()->intended('/home');
    //     }
    
    //     // Authentication failure
    //     return redirect()->route('login')->withErrors([
    //         'password' => __('The provided credentials are incorrect.'),
    //     ]);
    // }
    

    public function setGoogle2faSecretAttribute($value)
    {
        $user_id = Auth::user()->id;
        $secret_key = encrypt($value);
        
        User::where('id', $user_id)->update(
            ['google2fa_secret'=> $secret_key]
        );
    }

}
