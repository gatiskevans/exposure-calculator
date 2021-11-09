<?php

namespace App\Controllers;

use App\Calculator\ExposureCalculator;
use App\DD;
use App\Descriptions\ExposureValueDescriptions;
use App\Models\Exposure;
use App\Redirect\Redirect;
use App\Repositories\CsvExposuresRepository;
use App\Repositories\ExposuresRepository;
use App\Twig\TwigView;
use App\Validation\Exceptions\FormValidationException;
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

    public function calculateExposure(): void
    {
        try {
            $shutter = $this->validateShutter($_POST['shutter']);
            $_POST['shutter'] = $shutter == 0 ? "Not a number" : $shutter;
            $this->validateData($_POST);

            $exposure = new Exposure(Uuid::uuid4(), $_POST['iso'], $_POST['aperture'], $shutter);
            $result = (new ExposureCalculator($exposure))->calculate();

            $evDescription = ExposureValueDescriptions::getDescription($result);

            $this->exposuresRepository->save($exposure, $result);

            $_SESSION['form_data'] = [$_POST['iso'], $_POST['aperture'], $shutter];
            $_SESSION['result'] = $result;
            $_SESSION['description'] = $evDescription;
            Redirect::to('/');

        } catch (FormValidationException $exception)
        {
            $_SESSION['_errors'] = $this->getErrors();
            Redirect::to('/');
        }
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