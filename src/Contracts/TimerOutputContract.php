<?php

namespace Marshmallow\PhpTimer\Contracts;

interface TimerOutputContract
{
    public static function make(array $output_data): string;
    public function isActive(): bool;
    public function execute(array $output_data): string;
}
