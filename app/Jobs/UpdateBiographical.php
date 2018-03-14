<?php
declare(strict_types=1);

namespace Genealogy\Jobs;

use Genealogy\Entities\Biographical;
use Genealogy\Http\Requests\BiographicalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class UpdateBiographical
 * @package Genealogy\Jobs
 */
class UpdateBiographical implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Biographical
     */
    private $biographical;
    /**
     * @var array
     */
    private $attributes;

    /**
     * CreateBiographical constructor.
     * @param Biographical $biographical
     * @param array $attributes
     */
    public function __construct(
        Biographical $biographical,
        array $attributes = []
    ) {
        $this->biographical = $biographical;
        $this->attributes = array_only($attributes,
            ['birth_place', 'company', 'career', 'school', 'subject', 'degree', 'hobbies']);

    }

    /**
     * @param Biographical $biographical
     * @param BiographicalRequest $request
     * @return UpdateBiographical
     */
    public static function fromRequest(Biographical $biographical, BiographicalRequest $request): self
    {
        return new static(
            $biographical,
            [
                'birth_place' => $request->birthPlace(),
                'company' => $request->company(),
                'career' => $request->career(),
                'school' => $request->school(),
                'subject' => $request->subject(),
                'degree' => $request->degree(),
                'hobbies' => $request->hobbies(),
            ]
        );
    }

    /**
     * @return Biographical
     */
    public function handle(): Biographical
    {
        $this->biographical->update($this->attributes);

        return $this->biographical;
    }
}
