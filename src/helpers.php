<?php

function money($amount)
{
    return number_format($amount, 0, '.', ' ') . ' руб.';
}

function date_formatted($date)
{
    if(!$date) {
        return '';
    }

    $date = $date instanceof \Carbon\Carbon ? $date : new \Carbon\Carbon($date);

    return $date->format('j ') . monthLabel($date->format('n'), true)  . ( date('Y') != $date->format('Y') ? ' ' . $date->format('Y') : '');
}

function monthLabel($month, $another = false)
{
    $months = [
        1 => 'январь',
        2 => 'февраль',
        3 => 'март',
        4 => 'апрель',
        5 => 'май',
        6 => 'июнь',
        7 => 'июль',
        8 => 'август',
        9 => 'сентябрь',
        10 => 'октябрь',
        11 => 'ноябрь',
        12 => 'декабрь',
    ];

    $months2 = [
        1 => 'января',
        2 => 'февраля',
        3 => 'марта',
        4 => 'апреля',
        5 => 'мая',
        6 => 'июня',
        7 => 'июля',
        8 => 'августа',
        9 => 'сентября',
        10 => 'октября',
        11 => 'ноября',
        12 => 'декабря',
    ];

    return $another ? $months2[$month] : $months[$month];
}

function timePeriod($hour, $minutes, $duration)
{
    list($toHour, $toMinutes) = timeInterval($hour, $minutes, $duration);

    return sprintf(
        '%s:%s - %s:%s',
        $hour,
        str_pad($minutes, 2, '0'),
        $toHour,
        $toMinutes
    );
}

function timeInterval($hour, $minutes, $duration)
{
    $classDuration = 45;

    $duration = $classDuration * $duration;

    if($minutes + $duration > 59) {
        $hour = $hour + floor(($minutes + $duration)/60);
        $minutes = ($minutes + $duration)%60;
    } else {
        $minutes = $minutes + $duration;
    }

    return [$hour, str_pad($minutes, 2, '0')];
}

function array_to_object($array) {
    $obj = new stdClass;
    foreach($array as $k => $v) {
        if(strlen($k)) {
            if(is_array($v)) {
                $obj->{$k} = array_to_object($v); //RECURSION
            } else {
                $obj->{$k} = $v;
            }
        }
    }
    return $obj;
}

function el(string $tag, $attributes = null, $content = null) : string
{
    return \Spatie\HtmlElement\HtmlElement::render(...func_get_args());
}
