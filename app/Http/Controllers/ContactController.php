<?php
declare(strict_types=1);

namespace Genealogy\Http\Controllers;

use Genealogy\Entities\Contact;
use Genealogy\Http\Requests\ContactRequest;
use Genealogy\Jobs\UpdateContact;
use Illuminate\Http\RedirectResponse;

/**
 * Class ContactController
 * @package Genealogy\Http\Controllers
 */
class ContactController extends Controller
{
    /**
     * @param ContactRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function update(ContactRequest $request, Contact $contact): RedirectResponse
    {
        $this->dispatchNow(UpdateContact::fromRequest($contact, $request));
        $this->success('form.contacts.updated');

        return redirect()->route('home');
    }
}
