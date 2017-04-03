<?php

namespace App\Http\Controllers;

use Socialite;
use App\Repositories\UserRepository;

class LoginController extends Controller
{
    protected $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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

        $user = $this->userRepository->findOrCreate($twitterUser);

        auth()->login($user);

        return redirect('/');
    }

    public function destroy()
    {
        auth()->logout();

        return response()->json(['success' => true]);
    }
}
