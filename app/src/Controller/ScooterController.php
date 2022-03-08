<?php

namespace App\Controller;

use App\Model\Error;
use App\Repository\ScooterRepository;
use App\Response\ErrorCode;
use App\Response\ScootersResponse;
use Doctrine\ORM\Mapping as ORM;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\Scooter;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @ORM\Entity
 * @ORM\Table(name="scooter_controller")
 */
class ScooterController extends AbstractController
{
    /**
     * List all scooters
     * @Route("/scooters", methods={"GET"})
     *
     * @OA\Response(response="404", description="Not found",
     *     @OA\Schema(ref=@Model(type=Error::Class))
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns the scooters",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Scooter::class))
     *     )
     * )
     */
    public function index(ScooterRepository $repository, SerializerInterface $serializer): Response
    {
        $scooters = $repository->findAll();

        if (empty($scooters)) {
            return new JsonResponse(new Error(ErrorCode::ERROR_GENERAL, 'No scooters found!'), Response::HTTP_NOT_FOUND);
        }

        $scooterResponse = [];
        foreach ($scooters as $scooterFetched) {
            $scooter = new Scooter();
            $scooter->setUuid($scooterFetched->getUuid());
            $scooter->setStatus($scooterFetched->getStatus());
            $scooter->setLastLocations($scooterFetched->getLocations());

            $scooterResponse[] = $scooter;
        }

        $response = new ScootersResponse();
        $response->setScooters($scooterResponse);
        $responseObject = $serializer->serialize($response, 'json');

        return JsonResponse::fromJsonString($responseObject);
    }
}
