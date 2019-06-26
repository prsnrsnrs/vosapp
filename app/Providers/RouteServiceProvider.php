<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

//        $this->mapWebRoutes();

        $this->mapAgentRoutes();

        $this->mapAgentTestRoutes();

        $this->mapUserRoutes();

        $this->mapNonPublicRutes();

        $this->mapApsRoutes();

        $this->mapUplRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     *
     */
    protected function mapAgentRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->prefix('agent')
            ->as('agent.')
            ->group(base_path('routes/agent.php'));
    }

    /**
     * Define the "agent" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAgentTestRoutes()
    {
        Route::middleware('web')
            ->prefix('agent_test')
            ->as('agent_test.')
            ->namespace($this->namespace)
            ->group(base_path('routes/agent.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/user.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }


    /**
     * Define the "non_public" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapNonPublicRutes()
    {
        Route::prefix('non_public')
            ->namespace($this->namespace)
            ->group(base_path('routes/non_public.php'));
    }

    /**
     * i5専用
     */
    protected  function mapApsRoutes()
    {
        Route::middleware(['web', 'voss.aps'])
            ->namespace($this->namespace)
            ->prefix('aps')
            ->group(base_path('routes/aps.php'));
    }

    /**
     * UPLサーバー専用
     */
    protected function mapUplRoutes()
    {
        Route::middleware(['voss.upl'])
            ->namespace($this->namespace)
            ->prefix('upl')
            ->group(base_path('routes/upl.php'));
    }

}
