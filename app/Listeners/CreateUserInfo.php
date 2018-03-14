<?php
declare(strict_types=1);

namespace Genealogy\Listeners;

use Genealogy\Events\CreatedPerson;
use Genealogy\Events\RegisteredUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Genealogy\Jobs\CreatePerson;

/**
 * Class CreateUserInfo
 * @package Genealogy\Listeners
 */
class CreateUserInfo implements ShouldQueue
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
     * @param RegisteredUser $event
     */
    public function handle(RegisteredUser $event)
    {
        $this->dispatchNow(new CreatePerson($event->user));
    }
}
