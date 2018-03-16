<?php
declare(strict_types=1);

namespace Genealogy\Helpers;

use Genealogy\Http\Transformers\OptimusPrime;
use League\Fractal\TransformerAbstract;

/**
 * Class TransformerTrait
 * @package Genealogy\Helpers
 */
trait TransformerTrait
{
    protected $transformer;

    /**
     * @param TransformerAbstract $transformer
     */
    protected function setTransformer(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;
    }
    protected function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * @param $entity
     * @return mixed
     */
    protected function transform($entity)
    {
        $optimus = app(OptimusPrime::class);
        return $optimus->transform($entity, $this->getTransformer())['data'];
    }
}