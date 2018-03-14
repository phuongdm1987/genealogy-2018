<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Contact;
use Genealogy\Http\Requests\ContactRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UpdateContact
 * @package Genealogy\Jobs
 */
class UpdateContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Contact
     */
    private $contact;
    /**
     * @var array
     */
    private $attributes;

    /**
     * UpdateContact constructor.
     * @param Contact $contact
     * @param array $attributes
     */
    public function __construct(
        Contact $contact,
        array $attributes = []
    ) {
        $this->contact = $contact;
        $this->attributes = array_only($attributes, ['email', 'mobile', 'skype', 'facebook_url', 'address']);
    }

    /**
     * @param Contact $contact
     * @param ContactRequest $request
     * @return UpdateContact
     */
    public static function fromRequest(Contact $contact, ContactRequest $request): self
    {
        return new static(
            $contact,
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
        $this->contact->update($this->attributes);

        return $this->contact;
    }
}
