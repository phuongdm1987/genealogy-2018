<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Biographical;
use Genealogy\Entities\Person;
use Genealogy\Http\Requests\BiographicalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class CreateBiographical
 * @package Genealogy\Jobs
 */
class CreateBiographical implements ShouldQueue
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
     * CreateBiographical constructor.
     * @param Person $person
     * @param array $attributes
     */
    public function __construct(
        Person $person,
        array $attributes = []
    ) {
        $this->person = $person;
        $this->attributes = array_only($attributes, ['birth_place', 'company', 'career', 'school', 'subject', 'degree', 'hobbies']);

    }

    /**
     * @param Person $person
     * @param BiographicalRequest $request
     * @return CreateBiographical
     */
    public static function fromRequest(Person $person, BiographicalRequest $request): self
    {
        return new static(
            $person,
            [
                'birth_place' => $request->birthPlace(),
                'company' => $request->company(),
                'career' => $request->career(),
                'school' => $request->school(),
                'subject' => $request->subject(),
                'degree' => $request->degree(),
                'hobbies' => $request->hobbies()
            ]
        );
    }

    /**
     * @return Biographical
     */
    public function handle(): Biographical
    {
        $attributes = array_merge($this->attributes, ['person_id' => $this->person->id]);

        $biographical = new Biographical($attributes);
        $biographical->save();

        return $biographical;
    }
}
