<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class FacebookController extends Controller
{
    /**
     * Login using Facebook
     */
    public function loginUsingFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Callback for FB
     *
     * @return void
     */
    public function callbackFromFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();

            /**
             * Check users email if already there
             */
            $is_user = User::where('email', $user->getEmail())->first();

            if ( !$is_user ) {

                $saveUser = User::updateOrCreate([
                    'google_id' => $user->getId(),
                ],[
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make( $user->getName().'@'.$user->getId() ),
                    'api_token' => Str::random(80),
                ]);

                Auth::loginUsingId( $saveUser->id );

            } else {

                $saveUser = User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getId(),
                ]);

                $saveUser = User::where('email', $user->getEmail())->first();

                Auth::loginUsingId( $saveUser->id );

            }

            return redirect()->route( $this->admin_index_route )->withSuccess('Prihlásenie bolo úspešné.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
