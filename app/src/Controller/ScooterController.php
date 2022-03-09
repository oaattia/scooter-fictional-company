<?php

namespace App\Controller;

use App\Model\Error;
use App\Repository\ScooterRepository;
use App\Response\ErrorCode;
use App\Response\ScootersResponse;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\Scooter;
use Symfony\Component\Routing\Annotation\Route;
use App\Response\ScooterUpdatedResponse;
use App\Request\ScooterRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function getScooterAction(ScooterRepository $repository, SerializerInterface $serializer): Response
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

    /**
     * Update scooter status
     * @Route("/scooters/{uuid}", methods={"PUT"})
     *
     * @OA\Parameter(name="ScooterRequest",in="body",description="The data to update scooter",
     *     @OA\Schema(ref=@Model(type=ScooterRequest::class)
     * ))
     *
     * @OA\Response(response=200, description="scooter data updated successfully",
     *     @OA\Schema(ref=@Model(type=ScooterUpdatedResponse::class))
     * )
     *
     * @OA\Response(response=400, description="Bad Request",
     *     @OA\Schema(ref=@Model(type=Error::Class))
     * )
     */
    public function putScooterAction(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): Response
    {
        try {
            $content = $serializer->deserialize($request->getContent(),
                ScooterRequest::class, 'json');
        } catch (RuntimeException $exception) {
            return new JsonResponse(new Error(ErrorCode::ERROR_GENERAL,
                $exception->getMessage()), Response::HTTP_BAD_REQUEST);
        }

        $validationErrors = $validator->validate($content);
        if (\count($validationErrors) !== 0) {
            return new JsonResponse($serializer->serialize($validationErrors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        var_dump($content);die;
    }
}
