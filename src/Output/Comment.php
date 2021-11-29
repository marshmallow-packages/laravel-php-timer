<?php

namespace Marshmallow\PhpTimer\Output;

use Marshmallow\PhpTimer\Traits\Output;
use Marshmallow\PhpTimer\Contracts\TimerOutputContract;

class Comment implements TimerOutputContract
{
    use Output;

    public function execute(array $output_data): string
    {
        $output = "\n" . '<!--' . "\n";
        $output .= 'Here is your timer results: ' . "\n\n";
        foreach ($output_data as $timer) {
            $output .= $timer['name'] . ":\t\t" . $timer['time'] . ' seconds' . "\t\t" . $timer['percentage'] . "\n";
        }
        $output .= '-->';

        return $output;
    }

    public function isActive(): bool
    {
        return config('php-timer.output.comment');
    }
}
