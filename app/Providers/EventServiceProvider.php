<?php
declare(strict_types=1);

namespace Genealogy\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Genealogy\Events\RegisteredUser;
use Genealogy\Listeners\CreateUserInfo;
use Genealogy\Events\CreatedPerson;
use Genealogy\Listeners\CreatePersonInfo;

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
        RegisteredUser::class => [
            CreateUserInfo::class,
        ],
        CreatedPerson::class => [
            CreatePersonInfo::class,
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
