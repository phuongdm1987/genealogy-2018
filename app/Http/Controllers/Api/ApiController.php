<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers\Api;

use Genealogy\Helpers\JsonResponseHandler;
use Genealogy\Helpers\TransformerTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class ApiController
 * @package Genealogy\Http\Controllers\Api
 */
class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, TransformerTrait, JsonResponseHandler;
}
