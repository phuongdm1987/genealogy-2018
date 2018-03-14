<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Person;
use Genealogy\Http\Requests\PersonRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UpdatePerson
 * @package Genealogy\Jobs
 */
class UpdatePerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Person
     */
    private $person;
    /**
     * @var array
     */
    private $attributes;

    /**
     * UpdatePerson constructor.
     * @param Person $person
     * @param array $attributes
     */
    public function __construct(
        Person $person,
        array $attributes = []
    ) {
        $this->person = $person;
        $this->attributes = $attributes;
    }

    /**
     * @param Person $person
     * @param PersonRequest $request
     * @return UpdatePerson
     */
    public static function fromRequest(Person $person, PersonRequest $request): self
    {
        return new static(
            $person,
            [
                'first_name' => $request->firstName(),
                'middle_name' => $request->middleName(),
                'last_name' => $request->lastName(),
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
        $this->person->update($this->attributes);

        return $this->person;
    }
}
