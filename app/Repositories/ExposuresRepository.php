<?php

namespace App\Repositories;

use App\Models\Exposure;
use App\Models\ExposuresCollection;

interface ExposuresRepository
{
    public function save(Exposure $exposure, int $result): void;
    public function fetchAll(): ExposuresCollection;
    public function getOne(string $id): ?Exposure;
    public function delete(Exposure $exposure): void;
}