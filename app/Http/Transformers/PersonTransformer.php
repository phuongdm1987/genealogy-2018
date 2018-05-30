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
    /**
     * @param Person $person
     * @return array
     */
    public function transform(Person $person): array
    {
        $data = [
            'id'    => (int) $person->id,
            'parent_id' => $person->parent_id <= 0 ? null : $person->parent_id,
            'full_name'   => $person->getFullName(),
        ];

        return $data;
    }
}
