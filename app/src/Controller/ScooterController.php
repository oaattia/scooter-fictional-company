<?php

namespace App\Controller;

use App\Repository\ScooterRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScooterController extends AbstractFOSRestController
{
    /**
     * List all scooters
     * @Rest\Get("/scooters")
     */
    public function index(ScooterRepository $repository): Response
    {
        $scooters = $repository->findAll();
        return $this->handleView($this->view($scooters));
    }
}
