<?php

namespace App\Validation;

use App\Validation\Exceptions\FormValidationException;

class Validation
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validateData(array $data): void
    {
        if($data['iso'] < 100 || $data['iso'] > 102400){
            $this->errors['iso'] = "ISO must be between 100 and 102400";
        }

        if($data['aperture'] < 1 || $data['aperture'] > 64){
            $this->errors['aperture'] = "Aperture F-stop must be between 1 and 64";
        }

        if($data['shutter'] < 1/8000){
            $this->errors['shutter'] = "Shutter speed must be at least 1/8000 or higher";
        }

        if(!is_numeric($data['iso'])){
            $this->errors['iso'] = "ISO must be a number";
        }

        if(!is_numeric($data['aperture'])){
            $this->errors['aperture'] = "Aperture must be a number";
        }

        if(!is_numeric($data['shutter'])){
            $this->errors['shutter'] = "Shutter speed must be a number";
        }

        if(empty($data['iso']) || !isset($data['iso'])){
            $this->errors['iso'] = "ISO field is required";
        }

        if(empty($data['aperture']) || !isset($data['aperture'])){
            $this->errors['aperture'] = "Aperture field is required";
        }

        if(empty($data['shutter']) || !isset($data['shutter'])){
            $this->errors['shutter'] = "Shutter speed field is required";
        }

        if(count($this->errors) > 0){
            throw new FormValidationException();
        }
    }

    public function validateShutter($shutterData): float
    {
        $shutter = explode("/", $shutterData);
        if(count($shutter) > 1 && is_numeric($shutter[0]) && is_numeric($shutter[1])){
            [$numerator, $denominator] = explode("/", $shutterData);
            return $numerator/$denominator;
        }
        return (float) $shutterData;
    }
}