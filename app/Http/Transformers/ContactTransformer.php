<?php
declare(strict_types=1);

namespace Genealogy\Http\Transformers;

use Genealogy\Entities\Contact;
use League\Fractal\TransformerAbstract;

/**
 * Class ContactTransformer
 * @package Genealogy\Http\Transformers
 */
class ContactTransformer extends TransformerAbstract
{
    /**
     * @param Contact $contact
     * @return array
     */
    public function transform(Contact $contact): array
    {
        return [
            'id' => (int) $contact->id,
            'person_id' => (int) $contact->person_id,
            'email' => $contact->email,
            'mobile' => $contact->mobile,
            'skype' => $contact->skype,
            'facebook_url' => $contact->facebook_url,
            'address' => $contact->address,
        ];
    }
}
