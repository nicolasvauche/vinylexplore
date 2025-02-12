<?php

namespace App\Service\Match\Context;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TimeOfDayService
{
    private string $timezone;

    public function __construct(ParameterBagInterface $params)
    {
        $this->timezone = $params->get('app_timezone');
    }

    public function getTimeOfDay(): string
    {
        date_default_timezone_set($this->timezone);
        $hour = (int)date('H');

        if($hour >= 5 && $hour < 12) return 'matin';
        if($hour >= 12 && $hour < 14) return 'midi';
        if($hour >= 14 && $hour < 18) return 'après-midi';
        if($hour >= 18 && $hour < 22) return 'soir';

        return 'nuit';
    }
}
