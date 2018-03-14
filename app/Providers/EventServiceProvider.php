<?php
declare(strict_types=1);

namespace Genealogy\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 * @package Genealogy\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Genealogy\Events\RegisteredUser' => [
            'Genealogy\Listeners\CreateUserInfo',
        ],
        'Genealogy\Events\CreatedPerson' => [
            'Genealogy\Listeners\CreatePersonInfo',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
