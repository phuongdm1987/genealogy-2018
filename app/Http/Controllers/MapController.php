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
        $personTree = Person::all()->toTree();

//        $personDataTransform = [
//            'name' => 'Root',
//            'children' => [
//                [
//                    'name' => 'Branch 1',
//                ],
//                [
//                    'name' => 'Branch 2',
//                    'children' => [
//                        [
//                            'name' => 'Branch 2.1',
//                        ],
//                        [
//                            'name' => 'Branch 2.2',
//                            'children' => [
//                                [
//                                    'name' => 'Branch 2.2.1',
//                                ],
//                                [
//                                    'name' => 'Branch 2.2.2',
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//                [
//                    'name' => 'Branch 3',
//                ],
//                [
//                    'name' => 'Branch 4',
//                    'children' => [
//                        [
//                            'name' => 'Branch 4.1',
//                        ],
//                        [
//                            'name' => 'Branch 4.2',
//                        ],
//                    ],
//                ],
//                [
//                    'name' => 'Branch 5',
//                ],
//            ],
//        ];

        return response()->json(array_first($personTree));
    }
}
