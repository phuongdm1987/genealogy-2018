<?php
declare(strict_types=1);

namespace Genealogy\Events;

use Genealogy\Entities\Person;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

/**
 * Class CreatedPerson
 * @package Genealogy\Events
 */
class CreatedPerson
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $person;

    /**
     * Create a new event instance.
     *
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
