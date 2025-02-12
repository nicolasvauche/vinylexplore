<?php

namespace App\Service\Hub;

use App\Repository\Hub\MoodRepository;

class MoodService
{
    public function __construct(private readonly MoodRepository $moodRepository)
    {

    }

    public function getMoods(): array
    {
        return $this->moodRepository->FindAll();
    }
}
