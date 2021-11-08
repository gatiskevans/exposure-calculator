<?php

namespace App\Validation;

use App\DD;

class Validation
{
    public function validateData(array $data): void
    {

    }

    public function validateShutter($shutterData): float
    {
        $shutter = explode("/", $shutterData);
        if(count($shutter) > 1){
            [$numerator, $denominator] = explode("/", $shutterData);
            return $numerator/$denominator;
        }
        return $shutterData;
    }
}