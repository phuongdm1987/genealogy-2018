<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Entities\User;
use Genealogy\Helpers\GenerateTree;

/**
 * Class HomeController
 * @package Genealogy\Http\Controllers
 */
class HomeController extends Controller
{
    use GenerateTree;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(): \Illuminate\View\View
    {
        $person = \Auth::user()->person;
        $personTree = $this->generateTreeMap(Person::all()->toTree(), $person);

        return view('home', compact('person', 'personTree'));
    }
}
