<?php

namespace Marshmallow\PhpTimer\Traits;

trait Output
{
    public static function make(array $output_data): string
    {
        $output = new self();
        if ($output->isActive()) {
            return $output->execute($output_data);
        }

        return '';
    }
}
