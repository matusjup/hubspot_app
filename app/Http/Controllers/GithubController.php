<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class GithubController extends Controller
{
    /**
     * Login using Github
     */
    public function loginUsingGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Callback for GitHub
     *
     * @return void
     */
    public function callbackFromGithub()
    {
        try {
            $user = Socialite::driver('github')->user();

            /**
             * Check users email if already there
             */
            $is_user = User::where('email', $user->getEmail())->first();

            if ( !$is_user ) {


                $saveUser = User::updateOrCreate([
                    'github_id' => $user->getId(),
                ],[
                    'name' => $user->getName() ?? $user->getNickname(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make( $user->getName().'@'.$user->getId() ),
                    'api_token' => Str::random(80),
                ]);

                Auth::loginUsingId( $saveUser->id );

            } else {

                $saveUser = User::where('email', $user->getEmail())->update([
                    'github_id' => $user->getId(),
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
