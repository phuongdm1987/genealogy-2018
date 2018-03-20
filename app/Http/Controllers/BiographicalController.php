<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Biographical;
use Genealogy\Http\Requests\BiographicalRequest;
use Genealogy\Jobs\UpdateBiographical;
use Illuminate\Http\RedirectResponse;

/**
 * Class BiographicalController
 * @package Genealogy\Http\Controllers
 */
class BiographicalController extends Controller
{
    /**
     * @param BiographicalRequest $request
     * @param Biographical $biographical
     * @return RedirectResponse
     */
    public function update(BiographicalRequest $request, Biographical $biographical): RedirectResponse
    {
        $this->dispatchNow(UpdateBiographical::fromRequest($biographical, $request));

        $this->success('form.biographical.updated');
//
        return redirect()->route('home');
    }
}
