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
            'key'    => (int) $person->id,
            'parent' => (int) $person->parent_id,
            'text'   => $person->getFullName(),
            'loc'   => "{$person->id} {$person->id}",
            'brush' => 'skyblue',
            'dir' => 'right'
        ];

        if ($person->parent_id <= 0) {
            unset($data['parent'], $data['brush'], $data['dir']);
        }

        return $data;
    }
}