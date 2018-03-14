<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Person;
use Genealogy\Http\Requests\UploadAvatarRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UploadAvatarPerson
 * @package Genealogy\Jobs
 */
class UploadAvatarPerson implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Person
     */
    private $person;
    /**
     * @var UploadedFile
     */
    private $avatar;

    /**
     * UpdatePerson constructor.
     * @param Person $person
     * @param UploadedFile $avatar
     */
    public function __construct(
        Person $person,
        UploadedFile $avatar
    ) {
        $this->person = $person;
        $this->avatar = $avatar;
    }

    /**
     * @param Person $person
     * @param UploadAvatarRequest $request
     * @return UploadAvatarPerson
     */
    public static function fromRequest(Person $person, UploadAvatarRequest $request): self
    {
        return new static($person, $request->avatar());
    }

    /**
     * @return Person
     */
    public function handle(): Person
    {
        if (!$this->avatar) {
            return $this->person;
        }

        $filename = time() . '.' . $this->avatar->getClientOriginalExtension();
        \Image::make($this->avatar)->crop(200, 200)->save(storage_path('app/public/images/' . $filename));

        \Storage::delete(storage_path('app/public/images/' . $this->person->avatar));

        $this->person->update(['avatar' => $filename]);

        return $this->person;
    }
}
