<?php

use App\Models\MailTemplate;

if (! function_exists('random_color')) {
    function random_color(): string
    {
        $colors = [
            '#BF934C',
            '#1B1612',
            '#000000',
            '#708090',
            '#696969',
            '#808080',
        ];
        return $colors[array_rand($colors)];
    }
}

if (! function_exists('group_by_key')) {
    function group_by_key($array, $key)
    {
        $return = [];
        foreach ($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
}

if (! function_exists('days_array')) {
    function days_array(): array
    {
        return [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];
    }
}

if (! function_exists('day_index')) {
    function day_index($day)
    {
        return array_search($day, days_array(), true);
    }
}

if (! function_exists('get_24_hour_times')) {
    function get_24_hour_times($default = '09:00', $interval = '+30 minutes'): string
    {
        $output = '';

        $current = strtotime('00:00');
        $end = strtotime('23:59');

        while ($current <= $end) {
            $time = date('H:i', $current);
            $sel = ($time == $default) ? ' selected' : '';

            $output .= "<option value=\"{$time}\">" . date('H:i', $current) . '</option>';
            $current = strtotime($interval, $current);
        }

        return $output;
    }
}

if (! function_exists('get_times')) {
    function get_times($default = '09:00', $interval = '+30 minutes'): string
    {
        $output = '';

        $current = strtotime('00:00');
        $end = strtotime('23:59');

        while ($current <= $end) {
            $time = date('H:i', $current);
            $sel = ($time == $default) ? ' selected' : '';

            $output .= "<option value=\"{$time}\">" . date('h.i A', $current) . '</option>';
            $current = strtotime($interval, $current);
        }

        return $output;
    }
}

if (! function_exists('mail_template')) {
    function mail_template($type)
    {
        return MailTemplate::firstWhere('mail_type', $type);
    }
}

if (! function_exists('mail_template_by_id')) {
    function mail_template_by_id($id)
    {
        return MailTemplate::find($id);
    }
}
