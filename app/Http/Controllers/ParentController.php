<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Jobs\CreateParent;

/**
 * Class ParentController
 * @package Genealogy\Http\Controllers
 */
class ParentController extends Controller
{
    /**
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Person $person): \Illuminate\Http\RedirectResponse
    {
        $parent = $this->dispatchNow(CreateParent::fromRequest($person));
        $this->success('form.persons.created');

        return redirect()->route('persons.show', $parent->id);
    }
}
