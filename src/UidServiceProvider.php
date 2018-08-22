<?php

namespace ContinuumDigital\Uid;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class UidServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('uid', function() {
            $this->string('uid')->nullable()->unique();
        });

        Blueprint::macro('dropUid', function() {
            $this->dropColumn('uid');
        });
    }
}