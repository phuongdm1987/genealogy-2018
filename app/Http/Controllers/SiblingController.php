<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Jobs\CreateSibling;

/**
 * Class SiblingController
 * @package Genealogy\Http\Controllers
 */
class SiblingController extends Controller
{
    /**
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Person $person): \Illuminate\Http\RedirectResponse
    {
        $sibling = $this->dispatchNow(CreateSibling::fromRequest($person));
        $this->success('form.persons.created');

        return redirect()->route('persons.show', $sibling->id);
    }
}
