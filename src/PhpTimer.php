<?php

namespace Marshmallow\PhpTimer;

class PhpTimer
{
    protected $main_start_time;
    protected $main_end_time;

    protected $timers = [];

    public function start(string $name = null)
    {
        $this->main_start_time = hrtime(true);

        if ($name) {
            if (!array_key_exists($name, $this->timers)) {
                $this->timers[$name] = [
                    'start_time' => hrtime(true),
                    'end_time' => null,
                ];

                return '<!-- `' . $name . '` Timer has started -->' . "\n";
            }
        } else {
            return '<!-- `Main` Timer has started -->' . "\n";
        }
    }

    public function end(string $name = null)
    {
        if ($name) {
            if (array_key_exists($name, $this->timers)) {
                $this->timers[$name]['end_time'] = hrtime(true);
                return '<!-- `' . $name . '` Timer has ended -->' . "\n";
            }
        } else {
            $this->main_end_time = hrtime(true);
        }
        if (!$name) {
            return $this->output();
        }
    }

    protected function calculateTimerInSeconds($start, $end)
    {
        return ($end - $start) / 1000000000;   // Seconds
    }

    protected function percentage($total, $mark)
    {
        return round((($mark / $total) * 100), 4) . '%';
    }

    protected function output()
    {
        $output_data = [];
        $total_time = $this->calculateTimerInSeconds($this->main_start_time, $this->main_end_time);
        foreach ($this->timers as $name => $timer) {
            $time = $this->calculateTimerInSeconds($timer['start_time'], $timer['end_time']);
            $output_data[] = [
                'name' => $name,
                'time' => $time,
                'percentage' => $this->percentage($total_time, $time),
            ];
        }

        $output_data[] = [
            'name' => 'Total',
            'time' => $total_time,
            'percentage' => '100%',
        ];

        $output = $this->outputAsComment($output_data);
        $output .= $this->outputToBrowserConsole($output_data);
        $output .= $this->outputAlert($output_data);

        $this->outputToRay($output_data);

        return $output;
    }

    protected function outputAsComment(array $output_data)
    {
        $output = "\n" . '<!--' . "\n";
        $output .= 'Here is your timer results: ' . "\n\n";
        foreach ($output_data as $timer) {
            $output .= $timer['name'] . ":\t\t" . $timer['time'] . ' seconds' . "\t\t" . $timer['percentage'] . "\n";
        }
        $output .= '-->';

        return $output;
    }

    protected function outputToBrowserConsole($output_data)
    {
        $output = '<script>';
        $output .= 'console.warn("HERE IS YOUR TIMER RESULTS:");';
        $output .= 'console.log(' . json_encode($output_data) . ');';
        $output .= '</script>';

        return $output;
    }

    protected function outputAlert($output_data)
    {
        $output = '<script>';
        foreach ($output_data as $timer) {
            $string = $timer['name'] . ": " . $timer['time'] . ' seconds' . " " . $timer['percentage'];
            $output .= 'alert("' . $string . '");';
        }
        $output .= '</script>';

        return $output;
    }

    protected function outputToRay($output_data)
    {
        foreach ($output_data as $timer) {
            ray($timer['name'] . ":\t\t" . $timer['time'] . ' seconds' . "\t\t" . $timer['percentage']);
        }
    }
}
