<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Jobs\CreateChild;
use Illuminate\Http\RedirectResponse;


/**
 * Class ChildController
 * @package Genealogy\Http\Controllers
 */
class ChildController extends Controller
{
    /**
     * @param Person $person
     * @return RedirectResponse
     */
    public function create(Person $person): RedirectResponse
    {
        $child = $this->dispatchNow(CreateChild::fromRequest($person));
        $this->success('form.persons.created');

        return redirect()->route('persons.show', $child->id);
    }
}
