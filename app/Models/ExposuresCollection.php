<?php

namespace App\Models;

class ExposuresCollection
{
    private array $exposures = [];

    public function __construct(array $exposures = [])
    {
        foreach($exposures as $exposure){
            $this->add($exposure);
        }
    }

    public function add(Exposure $exposure): void
    {
        $this->exposures[$exposure->getId()] = $exposure;
    }

    public function getExposures(): array
    {
        return $this->exposures;
    }

    public function remove(Exposure $exposure): void
    {
        unset($this->exposures[$exposure->getId()]);
    }
}