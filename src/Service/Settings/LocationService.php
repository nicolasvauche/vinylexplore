<?php

namespace App\Service\Settings;

use App\Repository\Settings\LocationRepository;

readonly class LocationService
{
    public function __construct(private LocationRepository $locationRepository)
    {
    }

    public function getLocations(): array
    {
        return $this->locationRepository->findAll();
    }
}
