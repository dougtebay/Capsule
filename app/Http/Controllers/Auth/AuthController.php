<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $twitterUser = Socialite::driver('twitter')->user();

        $user = $this->userRepository->findOrCreate($twitterUser);

        auth()->login($user);

        return view('home');
    }
}
