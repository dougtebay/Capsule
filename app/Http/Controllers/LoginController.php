<?php

namespace App\Http\Controllers;

use Socialite;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class LoginController extends Controller
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
    public function create()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function callback()
    {
        $twitterUser = Socialite::driver('twitter')->user();
        $user = $this->userRepository->findOrCreate($twitterUser);
        auth()->login($user);

        return redirect()->action('LoginController@show');
    }

    public function show()
    {
        return view('home');
    }
}
