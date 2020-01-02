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
        'biographical',
        'children',
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
            'first_name' => $person->first_name,
            'middle_name' => $person->middle_name,
            'last_name' => $person->last_name,
            'full_name' => $person->getFullName(),
            'avatar' => $person->avatar,
            'avatar_path' => $person->getAvatar(),
            'sex' => (int) $person->sex,
            'sex_txt' => $person->sex_txt,
            'birth_of_date' => $person->getBirthOfDate(),
            'birth_of_time' => $person->getBirthOfTime(),
            'is_living' => $person->is_living,
            'death_of_date' => $person->getDeathOfDate(),
            'death_of_time' => $person->getDeathOfTime(),
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

    /**
     * @param Person $person
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChildren(Person $person): \League\Fractal\Resource\Collection
    {
        $children = $person->children;

        return $this->collection($children, new self);
    }
}
