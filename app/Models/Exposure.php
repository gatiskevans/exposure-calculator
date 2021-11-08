<?php

namespace App\Models;

use Ramsey\Uuid\Nonstandard\Uuid;

class Exposure
{
    private string $id;
    private int $ISO;
    private float $aperture;
    private float $shutterSpeed;

    public function __construct(string $id, int $ISO, float $aperture, float $shutterSpeed)
    {
        $this->id = $id;
        $this->ISO = $ISO;
        $this->aperture = $aperture;
        $this->shutterSpeed = $shutterSpeed;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAperture(): float
    {
        return $this->aperture;
    }

    public function getShutterSpeed(): float
    {
        return $this->shutterSpeed;
    }

    public function getISO(): int
    {
        return $this->ISO;
    }
}