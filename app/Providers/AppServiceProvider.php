<?php

namespace App\Providers;

use App\TaskLists\TaskListService;
use App\Tasks\TaskService;
use Illuminate\Support\Facades\Schema;
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
        //
        $this->app->bind('TaskLists\TaskListService', function($app) {
            return new TaskListService($app->make('Models\TaskList'), $app->make('Models\Task'));
        });

        $this->app->bind('Tasks\TaskService', function($app) {
            return new TaskService($app->make('Models\Task'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }
}
