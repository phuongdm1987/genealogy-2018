<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class DeletePerson
 * @package Genealogy\Jobs
 */
class DeletePerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Person
     */
    private $person;

    /**
     * Create a new job instance.
     *
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Execute the job.
     *
     * @return bool
     * @throws \Exception
     */
    public function handle(): bool
    {
        $this->person->contact->delete();
        $this->person->biographical->delete();
        \Storage::delete(storage_path('app/public/images/' . $this->person->avatar));

        return $this->person->delete();
    }
}
