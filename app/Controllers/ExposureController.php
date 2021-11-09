<?php

namespace App\Controllers;

use App\Calculator\ExposureCalculator;
use App\Descriptions\ExposureValueDescriptions;
use App\Models\Exposure;
use App\Redirect\Redirect;
use App\Repositories\CsvExposuresRepository;
use App\Repositories\ExposuresRepository;
use App\Twig\TwigView;
use App\Validation\Validation;
use Ramsey\Uuid\Uuid;

class ExposureController extends Validation
{
    private ExposuresRepository $exposuresRepository;

    public function __construct()
    {
        $this->exposuresRepository = new CsvExposuresRepository('Storage/exposures.csv');
    }

    public function index(): TwigView
    {
        return new TwigView('calculator.twig');
    }

    public function showHistory(): TwigView
    {
        $exposures = $this->exposuresRepository->fetchAll();

        return new TwigView('history.twig', ['exposures' => $exposures]);
    }

    public function showExposure(array $vars): TwigView
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $exposure = $this->exposuresRepository->getOne($id);
        $exposureValue = $this->exposuresRepository->getExposureValue($id);
        return new TwigView('viewExposure.twig',
            [
                'exposure' => $exposure,
                'exposureValue' => $exposureValue,
                'description' => ExposureValueDescriptions::getDescription($exposureValue)
            ]);
    }

    public function calculateExposure(): TwigView
    {
        if(!isset($_POST)){
            Redirect::to('/');
        }

        $shutter = $this->validateShutter($_POST['shutter']);

        $exposure = new Exposure(Uuid::uuid4(), $_POST['iso'], $_POST['aperture'], $shutter);
        $result = (new ExposureCalculator($exposure))->calculate();

        $evDescription = ExposureValueDescriptions::getDescription($result);

        $this->exposuresRepository->save($exposure, $result);

        return new TwigView('calculator.twig', [
            'result' => $result,
            'iso' => $_POST['iso'],
            'aperture' => $_POST['aperture'],
            'shutterSpeed' => $shutter,
            'description' => $evDescription
        ]);
    }

    public function delete(array $vars): void
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');

        $exposure = $this->exposuresRepository->getOne($id);
        $this->exposuresRepository->delete($exposure);

        Redirect::to('/history');
    }
}