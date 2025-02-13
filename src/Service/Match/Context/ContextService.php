<?php

namespace App\Service\Match\Context;

use App\Entity\User;

readonly class ContextService
{
    public function __construct(private TimeOfDayService $timeOfDayService,
                                private DayOfWeekService $dayOfWeekService,
                                private SeasonService    $seasonService)
    {
    }

    public function getContext(User $user): array
    {
        return [
            'timeOfDay' => $this->timeOfDayService->getTimeOfDay(),
            'dayOfWeek' => $this->dayOfWeekService->getDayOfWeek(),
            'season' => $this->seasonService->getSeason(),
            'mood' => strtolower($user->getMood()?->getName()),
            'location' => [
                'name' => strtolower($user->getLocation()?->getName()),
                'description' => $user->getLocation()?->getDescription(),
            ],
        ];
    }
}
