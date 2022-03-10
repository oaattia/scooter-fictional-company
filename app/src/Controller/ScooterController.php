<?php

namespace App\Controller;

use App\Entity\Location;
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
    const LIMIT = 20;

    /**
     * List all scooters
     * @Route("/scooters", methods={"GET"})
     *
     * @OA\Parameter(name="limit", in="query", description="max limit number of returned items")
     * @OA\Parameter(name="offset", in="query", description="offset of returned items")
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
    public function getScooterAction(Request $request, ScooterRepository $repository, SerializerInterface $serializer): Response
    {
        $limit = $request->query->getInt('limit', self::LIMIT);
        $offset = $request->query->getInt('offset');

        $scooters = $repository->getScootersMaxLimit($limit, $offset);

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
     * @OA\Response(response=404, description="Not found scooter",
     *     @OA\Schema(ref=@Model(type=Error::Class))
     * )
     */
    public function putScooterAction(string $uuid, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, ScooterRepository $repository): Response
    {
        try {
            /** @var ScooterRequest $scooterRequest */
            $scooterRequest = $serializer->deserialize($request->getContent(), ScooterRequest::class, 'json');
        } catch (RuntimeException $exception) {
            return new JsonResponse(new Error(ErrorCode::ERROR_INTERNAL_SERVER,
                $exception->getMessage()), Response::HTTP_BAD_REQUEST);
        }

        $validationErrors = $validator->validate($scooterRequest);
        if (\count($validationErrors) !== 0) {
            return new JsonResponse($serializer->serialize($validationErrors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }


        $scooter = $repository->findOneBy(['uuid' => $uuid]);

        if(empty($scooter)) {
            return new JsonResponse(new Error(ErrorCode::ERROR_GENERAL, sprintf('scooter uuid: (%s) not found!', $uuid)), Response::HTTP_NOT_FOUND);
        }

        $repository->update(
            $scooter,
            $scooterRequest->getStatus(),
            $scooterRequest->getCurrentDateTime(),
            $scooterRequest->getLongitude(),
            $scooterRequest->getLatitude()
        );

        $scooterUpdatedResponse = new ScooterUpdatedResponse();
        $scooterUpdatedResponse->setUuid($uuid);

        return new JsonResponse($scooterUpdatedResponse);
    }
}
