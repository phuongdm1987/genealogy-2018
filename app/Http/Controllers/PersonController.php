<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Person;
use Genealogy\Helpers\GenerateTree;
use Genealogy\Http\Requests\PersonRequest;
use Genealogy\Http\Requests\UploadAvatarRequest;
use Genealogy\Jobs\DeletePerson;
use Genealogy\Jobs\UpdatePerson;
use Genealogy\Jobs\UploadAvatarPerson;

/**
 * Class PersonController
 * @package Genealogy\Http\Controllers
 */
class PersonController extends Controller
{
    use GenerateTree;

    /**
     * @param Person $person
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Person $person)
    {
        $personTree = $this->generateTreeMap(Person::all()->toTree(), $person);

        return view('home', compact('person', 'personTree'));
    }

    /**
     * @param PersonRequest $request
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PersonRequest $request, Person $person): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchNow(UpdatePerson::fromRequest($person, $request));
        $this->success('form.persons.updated');

        return redirect()->route('persons.show', $person->id);
    }

    /**
     * @param UploadAvatarRequest $request
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadAvatar(UploadAvatarRequest $request, Person $person): \Illuminate\Http\RedirectResponse
    {
        $this->dispatchNow(UploadAvatarPerson::fromRequest($person, $request));
        $this->success('form.persons.uploaded');

        return redirect()->route('persons.show', $person->id);
    }

    /**
     * @param Person $person
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Person $person): \Illuminate\Http\RedirectResponse
    {
        if ($this->dispatchNow(new DeletePerson($person))) {
            $this->success('form.persons.deleted');

            return redirect()->home();
        }

        $this->error('Cancel not delete, because Person has children or own by other people!');
        return redirect()->back();
    }
}
