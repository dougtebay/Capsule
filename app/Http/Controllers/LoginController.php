<?php

namespace App\Http\Controllers;

use Socialite;
use App\Repositories\UserRepository;

class LoginController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $UserRepository;

    /**
     * Create a new session controller.
     *
     * @param  \App\Repositories\UserRepository  $userRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Obtain the user information from Twitter and log the user in.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function callback()
    {
        $twitterUser = Socialite::driver('twitter')->user();

        session()->put('token', $twitterUser->token);
        session()->put('tokenSecret', $twitterUser->tokenSecret);

        $user = $this->userRepository->findOrCreate($twitterUser);

        auth()->login($user);

        return redirect()->action('CollectionController@index');
    }

    /**
     * Log the user out.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function destroy()
    {
        auth()->logout();

        return response()->json(['success' => true]);
    }
}
