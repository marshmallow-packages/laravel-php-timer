<?php

namespace Marshmallow\PhpTimer\Output;

use Marshmallow\PhpTimer\Traits\Output;
use Marshmallow\PhpTimer\Contracts\TimerOutputContract;

class Ray implements TimerOutputContract
{
    use Output;

    public function execute(array $output_data): string
    {
        foreach ($output_data as $timer) {
            ray($timer['name'] . ":\t\t" . $timer['time'] . ' seconds' . "\t\t" . $timer['percentage']);
        }

        return '';
    }

    public function isActive(): bool
    {
        return config('php-timer.output.ray');
    }
}
