<?php

namespace App\Calculator;

use App\DD;
use App\Models\Exposure;

class ExposureCalculator
{
    private Exposure $exposure;

    public function __construct(Exposure $exposure)
    {
        $this->exposure = $exposure;
    }

    public function calculate(): int
    {
        return round(log((100 * pow($this->exposure->getAperture(), 2)) / ($this->exposure->getISO() * $this->exposure->getShutterSpeed()), 2));
    }
}