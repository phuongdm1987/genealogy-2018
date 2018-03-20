<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Jobs\CreateParent;
use Illuminate\Http\RedirectResponse;

/**
 * Class ParentController
 * @package Genealogy\Http\Controllers
 */
class ParentController extends Controller
{
    /**
     * @param Person $person
     * @return RedirectResponse
     */
    public function create(Person $person): RedirectResponse
    {
        $parent = $this->dispatchNow(CreateParent::fromRequest($person));
        $this->success('form.persons.created');

        return redirect()->route('persons.show', $parent->id);
    }
}
