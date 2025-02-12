<?php

namespace App\Service\Match\Context;

class SeasonService
{
    public function getSeason(): string
    {
        $month = (int)date('m');
        if(in_array($month, [12, 1, 2])) return 'hiver';
        if(in_array($month, [3, 4, 5])) return 'printemps';
        if(in_array($month, [6, 7, 8])) return 'été';

        return 'automne';
    }
}
