<?php

namespace Marshmallow\PhpTimer\Collections;

use Marshmallow\PhpTimer\Facades\PhpTimer;
use Illuminate\Database\Eloquent\Collection;

class TimerCollection extends Collection
{
    /**
     * Output the totals to an array which can be used in the
     * the output controller.
     */
    public function toOutputArray($total_time): array
    {
        return PhpTimer::outputArray(
            $this->getName(),
            $this->getTime(),
            $total_time
        );
    }

    /**
     * Add all the timers in the collection to the total time.
     *
     * @return float
     */
    protected function getTime(): float
    {
        $time = 0;
        $this->each(function ($timer) use (&$time) {
            $time += $timer->calculateTimerInSeconds();
        });

        return $time;
    }

    /**
     * Get the name from the first item in the collection.
     *
     * @return string
     */
    protected function getName(): string
    {
        return $this->first()->getName();
    }
}
