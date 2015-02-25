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
        // Hier können Sachen für die View hinterlegt werden
        // Wo soll die Variabel genutzt werden
    }

    public function register() {
        
    }

}
