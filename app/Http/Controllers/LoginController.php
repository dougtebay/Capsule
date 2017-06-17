<?php

namespace App\Http\Controllers;

use Socialite;
use App\Repositories\Users;

class LoginController extends Controller
{
    protected $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function create()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function callback()
    {
        $twitterUser = Socialite::driver('twitter')->user();

        session()->put('token', $twitterUser->token);
        session()->put('tokenSecret', $twitterUser->tokenSecret);

        $user = $this->users->findOrCreate($twitterUser);

        auth()->login($user);

        return redirect('/');
    }

    public function destroy()
    {
        auth()->logout();

        return response()->json(['success' => true]);
    }
}
