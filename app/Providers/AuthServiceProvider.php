<?php

namespace App\Providers;

use App\Models\Evento\Attachment;
use App\Models\Evento\Category;
use App\Models\Evento\Evento;
use App\Models\Evento\EventoCategory;
use App\Models\Evento\EventoTag;
use App\Models\Evento\EventoTagValue;
use App\Models\Evento\Tag;
use App\Models\ShortUrl\ShortUrlsCategory;
use App\Models\User;
use App\Policies\DocumentPolicy;
use App\Policies\Evento\AttachmentPolicy;
use App\Policies\Evento\CategoryPolicy;
use App\Policies\Evento\EventoCategoryPolicy;
use App\Policies\Evento\EventoPolicy;
use App\Policies\Evento\EventoTagPolicy;
use App\Policies\Evento\EventoTagValuePolicy;
use App\Policies\Evento\TagPolicy;
use App\Policies\EventPolicy;
use App\Policies\ShortUrlNewPolicy;
use App\Policies\ShortUrlPolicy;
use App\Models\ShortUrl\ShortUrl;
use App\Models\Event\Event;
use App\Models\Banner\Banner;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Adverts\Advert\Advert;

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
        Evento::class => EventoPolicy::class,
        Category::class => CategoryPolicy::class,
        Tag::class => TagPolicy::class,
        Attachment::class => AttachmentPolicy::class,
        EventoTag::class => EventoTagPolicy::class,
        EventoCategory::class => EventoCategoryPolicy::class,
        EventoTagValue::class => EventoTagValuePolicy::class,
        ShortUrlsCategory::class => ShortUrlNewPolicy::class,
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
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('manage-regions', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-adverts', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('manage-adverts-categories', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('manage-banners', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });

        Gate::define('show-advert', function (User $user, Advert $advert) {
            return $user->isAdmin() || $user->isModerator() || $advert->user_id === $user->id;
        });

        Gate::define('manage-own-advert', function (User $user, Advert $advert) {
            return $advert->user_id === $user->id;
        });

        Gate::define('manage-own-banner', function (User $user, Banner $banner) {
            return $banner->user_id === $user->id;
        });
    }
}
