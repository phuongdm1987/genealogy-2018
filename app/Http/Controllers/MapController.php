<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Http\Transformers\PersonTransformer;

/**
 * Class MapController
 * @package Genealogy\Http\Controllers
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
        $personTree = Person::all()->toTree()->first();

        return response()->json($personTree);
    }
}
