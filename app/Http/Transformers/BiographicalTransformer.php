<?php
declare(strict_types=1);

namespace Genealogy\Http\Transformers;

use Genealogy\Entities\Biographical;
use League\Fractal\TransformerAbstract;

/**
 * Class BiographicalTransformer
 * @package Genealogy\Http\Transformers
 */
class BiographicalTransformer extends TransformerAbstract
{
    /**
     * @param Biographical $biographical
     * @return array
     */
    public function transform(Biographical $biographical): array
    {
        return [
            'id' => (int) $biographical->id,
            'person_id' => (int) $biographical->person_id,
            'birth_place' => $biographical->birth_place,
            'company' => $biographical->company,
            'career' => $biographical->career,
            'school' => $biographical->school,
            'subject' => $biographical->subject,
            'degree' => $biographical->degree,
            'hobbies' => $biographical->hobbies,
        ];
    }
}
