<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Index login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Login method
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if( Auth::attempt( $credentials ) ):

            User::whereId( Auth::user()->id )->update([ 'api_token' => Str::random(80) ]);

            $request->session()->regenerate();

            return redirect()->route( $this->admin_index_route )->withSuccess('Prihlásenie bolo úspešné.');

        endif;

        return redirect()->route('login-page')->withErrors([ 'error_login' => 'Prihlásenie bolo neúspešné!' ]);
    }

    /**
     * Logout method
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login-page');
    }
}
