<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Person;
use Genealogy\Events\CreatedPerson;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class CreateParent
 * @package Genealogy\Jobs
 */
class CreateParent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Person
     */
    private $person;

    /**
     * CreateParent constructor.
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * @param Person $person
     * @return CreateParent
     */
    public static function fromRequest(Person $person): self
    {
        return new static($person);
    }

    /**
     * @return Person
     */
    public function handle(): Person
    {
        /** @var Person $parent */
        $parent = $this->person->replicate(['first_name', 'middle_name', 'last_name', 'avatar', 'sex', 'birth_of_date', 'is_living', 'death_of_date']);
        $parent->last_name = 'Parent of ' . $this->person->last_name;
        $parent->save();

        $this->person->parent_id = $parent->id;
        $this->person->save();

        event(new CreatedPerson($parent));

        return $parent;
    }
}
