<?php
declare(strict_types=1);

namespace Genealogy\Http\Transformers;

use Illuminate\Pagination\AbstractPaginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use \Illuminate\Database\Eloquent\Collection as EloquentCollection;
use League\Fractal\Resource\Item;

/**
 * Class OptimusPrime
 * @package Genealogy\Http\Transformers
 */
class OptimusPrime
{
    protected $manager;

    /**
     * OptimusPrime constructor.
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        $this->parseIncludes();
    }

    public function parseIncludes()
    {
        if (isset($_GET['include'])) {
            $this->manager->parseIncludes($_GET['include']);
        }
    }

    /**
     * @param $include
     */
    public function setIncludes($include) {
        $this->manager->parseIncludes($include);
    }

    /**
     * @param $entity
     * @param $transformer
     * @return array
     */
    public function transform($entity, $transformer): array
    {
        if ($entity instanceof AbstractPaginator)
        {
            $resource = new Collection($entity->getCollection(), $transformer);

            $queryParams = array_diff_key($_GET, array_flip(['page']));
            $entity->appends($queryParams);
            $resource->setPaginator(new IlluminatePaginatorAdapter($entity));
        }
        else if ($entity instanceof EloquentCollection)
        {
            $resource = new Collection($entity, $transformer);
        }
        else
        {
            $resource = new Item($entity, $transformer);
        }

        return $this->manager->createData($resource)->toArray();
    }
}