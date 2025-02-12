<?php

namespace App\Service\Match\Context;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DayOfWeekService
{
    private string $timezone;
    private string $locale;

    public function __construct(ParameterBagInterface $params)
    {
        $this->timezone = $params->get('app_timezone');
        $this->locale = $params->get('app_locale');
    }

    /**
     * @throws \DateMalformedStringException
     * @throws \DateInvalidTimeZoneException
     */
    public function getDayOfWeek(): string
    {
        $formatter = new \IntlDateFormatter(
            $this->locale,
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            $this->timezone,
            \IntlDateFormatter::GREGORIAN,
            'EEEE'
        );

        return strtolower($formatter->format(new \DateTime('now', new \DateTimeZone($this->timezone))));
    }
}
