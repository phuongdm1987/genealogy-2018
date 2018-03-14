<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Person;
use Genealogy\Entities\User;
use Genealogy\Events\CreatedPerson;
use Genealogy\Http\Requests\PersonRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class CreatePerson
 * @package Genealogy\Jobs
 */
class CreatePerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var User|null
     */
    private $user;
    /**
     * @var array
     */
    private $attributes;

    /**
     * CreatePerson constructor.
     * @param User|null $user
     * @param array $attributes
     */
    public function __construct(
        User $user = null,
        array $attributes = []
    ) {
        $this->user = $user;
        $this->attributes = array_only($attributes, ['first_name', 'middle_name', 'last_name', 'avatar', 'sex', 'birth_of_date', 'is_living', 'death_of_date']);
    }

    /**
     * @param User|null $user
     * @param PersonRequest $request
     * @return CreatePerson
     */
    public static function fromRequest(User $user = null, PersonRequest $request): self
    {
        return new static(
            $user,
            [
                'first_name' => $request->firstName(),
                'middle_name' => $request->middleName(),
                'last_name' => $request->lastName(),
                'avatar' => $request->avatar(),
                'sex' => $request->sex(),
                'birth_of_date' => $request->birthOfDate(),
                'is_living' => $request->isLiving(),
                'death_of_date' => $request->deathOfDate(),
            ]
        );
    }

    /**
     * @return Person
     */
    public function handle(): Person
    {
        $user_id = $this->user ? $this->user->id : 0;
        $attributes = array_merge($this->attributes, ['user_id' => $user_id]);

        $person = new Person($attributes);
        $person->save();

        event(new CreatedPerson($person));

        return $person;
    }
}
