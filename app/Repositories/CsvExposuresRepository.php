<?php

namespace App\Repositories;

use App\Models\Exposure;
use App\Models\ExposuresCollection;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvExposuresRepository implements ExposuresRepository
{
    private string $path;
    private Reader $exposures;

    public function __construct(string $path)
    {
        $this->path = $path;

        if (!file_exists($path)) Writer::createFromPath($this->path, 'w');
        $this->exposures = Reader::createFromPath($path);
    }

    public function save(Exposure $exposure, int $result): void
    {
        $writer = Writer::createFromPath($this->path, 'a');
        $writer->insertOne([
            $exposure->getId(),
            $exposure->getISO(),
            $exposure->getAperture(),
            $exposure->getShutterSpeed(),
            $exposure->getExposureValue(),
            $exposure->getDescription()
        ]);
    }

    public function fetchAll(): ExposuresCollection
    {
        $exposuresCollection = new ExposuresCollection();

        foreach(Statement::create()->process($this->exposures) as $exposure){
            $exposuresCollection->add(new Exposure(
                $exposure[0],
                $exposure[1],
                $exposure[2],
                (float) $exposure[3],
                $exposure[4],
                $exposure[5]
            ));
        }

        return $exposuresCollection;
    }

    public function getOne(string $id): ?Exposure
    {
        $statement = Statement::create()->where(
            function ($exposure) use ($id) {
                return $exposure[0] === $id;
            }
        );

        $exposure = $statement->process($this->exposures)->fetchOne();

        if (empty($exposure)) return null;

        return new Exposure(
            $exposure[0],
            $exposure[1],
            $exposure[2],
            $exposure[3],
            $exposure[4],
            $exposure[5]
        );
    }

    public function getExposureValue(string $id): ?int
    {
        $statement = Statement::create()->where(
            function ($exposure) use ($id) {
                return $exposure[0] === $id;
            }
        );

        $exposure = $statement->process($this->exposures)->fetchOne();

        if (empty($exposure)) return null;

        return $exposure[4];
    }

    public function delete(Exposure $exposure): void
    {
        $exposures = $this->fetchAll();
        $exposures->remove($exposure);

        $tempExposures = [];

        foreach($exposures->getExposures() as $exposure){
            $tempExposures[] = [
                $exposure->getId(),
                $exposure->getISO(),
                $exposure->getAperture(),
                $exposure->getShutterSpeed(),
                $exposure->getExposureValue(),
                $exposure->getDescription()
            ];
        }

        $writer = Writer::createFromPath($this->path, 'w');
        $writer->insertAll($tempExposures);
    }
}