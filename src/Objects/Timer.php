<?php

namespace Marshmallow\PhpTimer\Objects;

use Marshmallow\PhpTimer\Facades\PhpTimer;

class Timer
{
    /**
     * The name of this timer.
     *
     * @var string
     */
    protected string $name;

    /**
     * The start time from hrtime
     *
     * @var integer
     */
    protected int $start_time;

    /**
     * The end time from hrtime
     *
     * @var integer
     */
    protected int $end_time;

    /**
     * Initialize a new Timer object.
     *
     * @param string $name
     * @return Marshmallow\PhpTimer\Objects\Timer
     */
    public static function start($name): self
    {
        return (new self)->setName($name)->setStartTime();
    }

    /**
     * Give this timer a name.
     *
     * @param string $name
     * @return Marshmallow\PhpTimer\Objects\Timer $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the start time of this timer.
     *
     * @return Marshmallow\PhpTimer\Objects\Timer $this
     */
    public function setStartTime(): self
    {
        $this->start_time = hrtime(true);
        return $this;
    }

    /**
     * Set the end time of this timer.
     *
     * @return Marshmallow\PhpTimer\Objects\Timer $this
     */
    public function stop(): self
    {
        $this->end_time = hrtime(true);
        return $this;
    }

    /**
     * Calculate the timer in seconds.
     *
     * @return string
     */
    public function calculateTimerInSeconds(): float
    {
        return ($this->end_time - $this->start_time) / 1000000000;
    }

    /**
     * Return a comment that the timer has started.
     *
     * @return string
     */
    public function outputStartComment(): string
    {
        return '<!-- `' . $this->name . '` timer has started -->' . "\n";
    }

    /**
     * Return a comment that the timer has ended.
     *
     * @return string
     */
    public function outputStopComment(): string
    {
        return '<!-- `' . $this->name . '` timer has ended -->' . "\n";
    }

    /**
     * Get the name of this timer.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Output the totals to an array which can be used in the
     * the output controller.
     *
     * @param float $total_time
     * @return array
     */
    public function toArray(float $total_time): array
    {
        return PhpTimer::outputArray(
            $this->name,
            $this->calculateTimerInSeconds(),
            $total_time
        );
    }
}
