<?php

namespace App\Providers;

use App\Contracts\FamilyTree\YoungestDescendantCache;
use App\Contracts\FamilyTree\YoungestDescendant;
use App\Services\FamilyTree\YoungestDescendantCacheService;
use App\Services\FamilyTree\FamilyTreeService;
use App\Services\FamilyTree\YoungestDescendantTaggedCacheService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFamilyTree();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerFamilyTree(): void
    {
        $this->app->bind(YoungestDescendant::class, FamilyTreeService::class);

        $this->app->bind(YoungestDescendantCache::class, function (Application $app) {
            if ($app->get('cache')->supportsTags()) {
                return $app->make(YoungestDescendantTaggedCacheService::class);
            }

            return $app->make(YoungestDescendantCacheService::class);
        });
    }
}
