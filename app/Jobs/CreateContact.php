<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Contact;
use Genealogy\Entities\Person;
use Genealogy\Http\Requests\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class CreateContact
 * @package Genealogy\Jobs
 */
class CreateContact implements ShouldQueue
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
     * CreateContact constructor.
     * @param Person $person
     * @param array $attributes
     */
    public function __construct(
        Person $person,
        array $attributes = []
    ) {
        $this->person = $person;
        $this->attributes = array_only($attributes, ['email', 'mobile', 'skype', 'facebook_url', 'address']);
    }

    /**
     * @param Person $person
     * @param ContactRequest $request
     * @return CreateContact
     */
    public static function fromRequest(Person $person, ContactRequest $request): self
    {
        return new static(
            $person,
            [
                'email' => $request->email(),
                'mobile' => $request->mobile(),
                'skype' => $request->skype(),
                'facebook_url' => $request->facebookUrl(),
                'address' => $request->address()
            ]
        );
    }

    /**
     * @return Contact
     */
    public function handle(): Contact
    {
        $attributes = array_merge($this->attributes, ['person_id' => $this->person->id]);

        $contact = new Contact($attributes);
        $contact->save();

        return $contact;
    }
}
