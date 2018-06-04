<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers\Api;

use Genealogy\Entities\Person;
use Genealogy\Http\Requests\PersonRequest;
use Genealogy\Http\Transformers\PersonTransformer;
use Genealogy\Jobs\UpdatePerson;
use Illuminate\Http\JsonResponse;

/**
 * Class PersonController
 * @package Genealogy\Http\Controllers\Api
 */
class PersonController extends ApiController
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
     * @return JsonResponse
     */
    public function show(Person $person): JsonResponse
    {
        return $this->successResponse($person);
    }

    /**
     * @param PersonRequest $request
     * @param Person $person
     * @return JsonResponse
     */
    public function update(PersonRequest $request, Person $person): JsonResponse
    {
        $person = $this->dispatchNow(UpdatePerson::fromRequest($person, $request));

        return $this->successResponse($person);
    }

    /**
     * @return JsonResponse
     */
    public function getSexes(): JsonResponse
    {
        return $this->successResponse(Person::SEX, false);
    }
}
