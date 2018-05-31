<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers\Api;

use Genealogy\Entities\Person;
use Genealogy\Http\Controllers\Controller;
use Genealogy\Http\Transformers\PersonTransformer;
use Illuminate\Http\Request;

/**
 * Class PersonController
 * @package Genealogy\Http\Controllers\Api
 */
class PersonController extends Controller
{

    /**
     * PersonController constructor.
     * @param PersonTransformer $transformer
     */
    public function __construct(PersonTransformer $transformer)
    {
        $this->setTransformer($transformer);
    }

    /**
     * @param Person $person
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function show(Person $person)
    {
        $personTransform = $this->transform($person);

        return response()->json($personTransform);
    }
}
