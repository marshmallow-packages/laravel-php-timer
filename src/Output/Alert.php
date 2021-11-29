<?php

namespace Marshmallow\PhpTimer\Output;

use Marshmallow\PhpTimer\Traits\Output;
use Marshmallow\PhpTimer\Contracts\TimerOutputContract;

class Alert implements TimerOutputContract
{
    use Output;

    public function execute(array $output_data): string
    {
        $output = '<script>';
        foreach ($output_data as $timer) {
            $string = $timer['name'] . ": " . $timer['time'] . ' seconds' . " " . $timer['percentage'];
            $output .= 'alert("' . $string . '");';
        }
        $output .= '</script>';

        return $output;
    }

    public function isActive(): bool
    {
        return config('php-timer.output.alert');
    }
}
