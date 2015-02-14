<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        // Kann um die eigene Struktur erweitert und geändert werden
        
        $view->composer('user.*', 'App\Http\ViewComposers\AclComposer');
    }

    public function register() {
        
    }

}
