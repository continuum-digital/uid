<?php

namespace ContinuumDigital\Uid;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class UidServiceProvider extends ServiceProvider
{
    /**
     * Indicates if the loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('uid', function() {
            $this->string('uid')->nullable()->unique();
        });

        Blueprint::macro('dropUid', function() {
            $this->dropColumn('uid');
        });
    }
}