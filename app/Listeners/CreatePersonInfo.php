<?php
declare(strict_types=1);

namespace Genealogy\Listeners;

use Genealogy\Events\CreatedPerson;
use Genealogy\Jobs\CreateBiographical;
use Genealogy\Jobs\CreateContact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CreatePersonInfo
 * @package Genealogy\Listeners
 */
class CreatePersonInfo implements ShouldQueue
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param CreatedPerson $event
     */
    public function handle(CreatedPerson $event)
    {
        $person = $event->person;

        $this->dispatchNow(new CreateContact($person));
        $this->dispatchNow(new CreateBiographical($person));
    }
}
