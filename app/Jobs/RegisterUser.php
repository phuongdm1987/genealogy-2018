<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\User;
use Genealogy\Events\RegisteredUser;
use Genealogy\Exceptions\CannotCreateUser;
use Genealogy\Http\Requests\RegisterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class RegisterUser
 * @package Genealogy\Jobs
 */
class RegisterUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * RegisterUser constructor.
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @param RegisterRequest $request
     * @return RegisterUser
     */
    public static function fromRequest(RegisterRequest $request): self
    {
        return new static(
            $request->username(),
            $request->emailAddress(),
            $request->password()
        );
    }

    /**
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws CannotCreateUser
     */
    public function handle(): User
    {
        $this->assertUsernameIsUnique($this->username);

        $user = new User([
            'username' => strtolower($this->username),
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'remember_token' => ''
        ]);
        $user->save();

        event(new RegisteredUser($user));

        return $user;
    }

    /**
     * @param string $username
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws CannotCreateUser
     */
    private function assertUsernameIsUnique(string $username): bool
    {
        try {
            User::findByUsername($username);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateUsername($username);
    }
}
