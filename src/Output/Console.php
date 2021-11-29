<?php

namespace Marshmallow\PhpTimer\Output;

use Marshmallow\PhpTimer\Traits\Output;
use Marshmallow\PhpTimer\Contracts\TimerOutputContract;

class Console implements TimerOutputContract
{
    use Output;

    public function execute(array $output_data): string
    {
        $output = '<script>';
        $output .= 'console.warn("HERE IS YOUR TIMER RESULTS:");';
        $output .= 'console.log(' . json_encode($output_data) . ');';
        $output .= '</script>';

        return $output;
    }

    public function isActive(): bool
    {
        return config('php-timer.output.console');
    }
}
