<?php

namespace App\Models;

class Exposure
{
    private string $id;
    private int $ISO;
    private float $aperture;
    private float $shutterSpeed;
    private ?int $exposureValue;
    private ?string $description;

    public function __construct(
        string $id,
        int $ISO,
        float $aperture,
        $shutterSpeed,
        int $exposureValue = null,
        string $description = null
    )
    {
        $this->id = $id;
        $this->ISO = $ISO;
        $this->aperture = $aperture;
        $this->shutterSpeed = $shutterSpeed;
        $this->exposureValue = $exposureValue;
        $this->description = $description;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getExposureValue(): ?int
    {
        return $this->exposureValue;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setExposureValue(?int $exposureValue): void
    {
        $this->exposureValue = $exposureValue;
    }
}