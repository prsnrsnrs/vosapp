<?php

namespace App\Providers;

use Illuminate\Log\LogServiceProvider as ServiceProvider;
use Illuminate\Log\Writer as Writer;

class LogServiceProvider extends ServiceProvider
{
    protected function configureDailyHandler(Writer $log)
    {
        $log->useDailyFiles(
            $this->app->storagePath().'/logs/voss.log',
            $this->maxFiles(),
            $this->logLevel()
        );
    }
}