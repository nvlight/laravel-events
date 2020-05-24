<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\DocumentPolicy;
use App\Policies\EventPolicy;
use App\Policies\ShortUrlPolicy;
use App\Models\ShortUrl\ShortUrl;
use App\Models\Event\Event;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        //'App\Model' => 'App\Policies\EventPolicy',

        //'App\Models\ShortUrl\ShortUrl' => 'App\Policies\ShortUrlPolicy',
        //ShortUrl::class => 'App\Policies\ShortUrlPolicy',

        Document::class => DocumentPolicy::class,
        ShortUrl::class => ShortUrlPolicy::class,
        Event::class => EventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-panel', function (User $user) {
            return $user->isAdmin();
        });
    }
}
