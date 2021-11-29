<?php

namespace Marshmallow\PhpTimer;

use Marshmallow\PhpTimer\Output\Ray;
use Marshmallow\PhpTimer\Output\Alert;
use Marshmallow\PhpTimer\Objects\Timer;
use Marshmallow\PhpTimer\Output\Comment;
use Marshmallow\PhpTimer\Output\Console;
use Marshmallow\PhpTimer\Collections\TimerCollection;

class PhpTimer
{
    protected ?Timer $total_timer = null;

    protected string $output = '';

    protected array $timers = [];

    protected array $output_data = [];

    public function start(string $name = null): ?string
    {
        if ($name) {
            if (!array_key_exists($name, $this->timers)) {
                $this->timers[$name] = new TimerCollection([]);
            }

            $timer = $this->timers[$name]->add(Timer::start($name));

            return $timer->last()->outputStartComment();
        } else {
            $this->total_timer = Timer::start(__('Main'));
            return $this->total_timer->outputStartComment();
        }
    }

    public function end(string $name = null): ?string
    {
        if ($name) {
            if (array_key_exists($name, $this->timers)) {
                $timer = $this->timers[$name]->last();
                return $timer->stop()->outputStopComment();
            }
        } else {
            $this->total_timer->stop();
            return $this->output();
        }
    }

    protected function output(): string
    {
        $total_time = $this->total_timer->calculateTimerInSeconds();
        foreach ($this->timers as $timer_collection) {
            $this->output_data[] = $timer_collection->toOutputArray($total_time);
        }

        $this->output_data[] = $this->total_timer->toArray($total_time);

        return $this->commentOutput()
            ->consoleOutput()
            ->alertOutput()
            ->rayOutput()
            ->getOutput();
    }

    protected function setOutput(string $output): self
    {
        $this->output .= $output;
        return $this;
    }

    protected function commentOutput(): self
    {
        return $this->setOutput(
            Comment::make($this->output_data)
        );
    }

    protected function consoleOutput(): self
    {
        return $this->setOutput(
            Console::make($this->output_data)
        );
    }

    protected function alertOutput(): self
    {
        return $this->setOutput(
            Alert::make($this->output_data)
        );
    }

    protected function rayOutput(): self
    {
        Ray::make($this->output_data);
        return $this;
    }

    protected function getOutput(): string
    {
        return $this->output;
    }

    public function percentage($total, $mark): string
    {
        return round((($mark / $total) * 100), 4) . '%';
    }

    /**
     * Output the totals to an array which can be used in the
     * the output controller.
     */
    public function outputArray(string $name, float $time, float $total_time): array
    {
        return [
            'name' => $name,
            'time' => $time,
            'percentage' => $this->percentage($total_time, $time),
        ];
    }
}
