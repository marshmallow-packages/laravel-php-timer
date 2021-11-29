<?php

namespace Marshmallow\PhpTimer;

use Illuminate\Support\Facades\Blade;
use Marshmallow\PhpTimer\Facades\PhpTimer;
use Marshmallow\PhpTimer\View\Components\PhpTimerComponent;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/php-timer.php',
            'php-timer'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'php-timer');

        $this->publishes([
            __DIR__ . '/../config/php-timer.php' => config_path('php-timer.php'),
        ]);

        Blade::directive('startTimer', function ($expression) {
            return "<?php echo \Marshmallow\PhpTimer\Facades\PhpTimer::start($expression); ?>";
        });

        Blade::directive('endTimer', function ($expression) {
            return "<?php echo \Marshmallow\PhpTimer\Facades\PhpTimer::end($expression); ?>";
        });
    }
}
