<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function clearSecretKey(Request $request){
        // Clear session data if OTP is valid
        $request->session()->remove('2FA:user:id');
        $request->session()->remove('google2fa_secret');

        $user_id = Auth::user()->id;
        User::where('id', $user_id)->update(
            ['google2fa_secret'=> null]
        );

        return redirect('home');
    }
}
