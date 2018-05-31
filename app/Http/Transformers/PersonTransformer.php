<?php
declare(strict_types=1);

namespace Genealogy\Http\Transformers;

use Genealogy\Entities\Person;
use League\Fractal\TransformerAbstract;

/**
 * Class PersonTransformer
 * @package Genealogy\Http\Transformers
 */
class PersonTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'contact',
        'biographical'
    ];

    /**
     * @param Person $person
     * @return array
     */
    public function transform(Person $person): array
    {
        $data = [
            'id' => (int) $person->id,
            'parent_id' => $person->parent_id <= 0 ? null : $person->parent_id,
            'full_name' => $person->getFullName(),
            'avatar_path' => $person->getAvatar(),
            'sex_txt' => $person->sex_txt,
            'bod' => $person->bod,
            'dod' => $person->dod,
        ];

        return $data;
    }

    /**
     * @param Person $person
     * @return \League\Fractal\Resource\Item
     */
    public function includeContact(Person $person): \League\Fractal\Resource\Item
    {
        $contact = $person->contact;

        return $this->item($contact, new ContactTransformer);
    }

    /**
     * @param Person $person
     * @return \League\Fractal\Resource\Item
     */
    public function includeBiographical(Person $person): \League\Fractal\Resource\Item
    {
        $biographical = $person->biographical;

        return $this->item($biographical, new BiographicalTransformer);
    }
}
