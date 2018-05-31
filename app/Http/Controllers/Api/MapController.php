<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers\Api;

use Genealogy\Entities\Person;
use Genealogy\Http\Controllers\Controller;
use Genealogy\Http\Transformers\PersonTransformer;

/**
 * Class MapController
 * @package Genealogy\Http\Controllers\Api
 */
class MapController extends Controller
{

    /**
     * MapController constructor.
     * @param PersonTransformer $transformer
     */
    public function __construct(PersonTransformer $transformer)
    {
        $this->setTransformer($transformer);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
//        $personDataTransform = $this->transform(Person::all());
        $personTree = Person::all()->toTree()->first();

        return response()->json($personTree);
    }
}
