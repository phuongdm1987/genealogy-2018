<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Entities\User;
use Genealogy\Helpers\GenerateTree;
use Illuminate\View\View;

/**
 * Class HomeController
 * @package Genealogy\Http\Controllers
 */
class HomeController extends Controller
{
    use GenerateTree;

    /**
     * @return View
     */
    public function index(): View
    {
        $person = \Auth::user()->person;
        $personTree = $this->generateTreeMap(Person::all()->toTree(), $person);

        return view('home', compact('person', 'personTree'));
    }
}
