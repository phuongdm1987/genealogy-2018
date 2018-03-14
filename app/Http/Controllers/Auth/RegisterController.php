<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers\Auth;

use Genealogy\Entities\User;
use Genealogy\Http\Controllers\Controller;
use Genealogy\Http\Middleware\RedirectIfAuthenticated;
use Genealogy\Http\Requests\RegisterRequest;
use Genealogy\Jobs\RegisterUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package Genealogy\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(RedirectIfAuthenticated::class);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, app(RegisterRequest::class)->rules());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \Genealogy\Entities\User
     */
    protected function create(array $data): User
    {
        $user = $this->dispatchNow(RegisterUser::fromRequest(app(RegisterRequest::class)));

        return $user;
    }
}
