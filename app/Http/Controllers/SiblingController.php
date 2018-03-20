<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Jobs\CreateSibling;
use Illuminate\Http\RedirectResponse;

/**
 * Class SiblingController
 * @package Genealogy\Http\Controllers
 */
class SiblingController extends Controller
{
    /**
     * @param Person $person
     * @return RedirectResponse
     */
    public function create(Person $person): RedirectResponse
    {
        $sibling = $this->dispatchNow(CreateSibling::fromRequest($person));
        $this->success('form.persons.created');

        return redirect()->route('persons.show', $sibling->id);
    }
}
