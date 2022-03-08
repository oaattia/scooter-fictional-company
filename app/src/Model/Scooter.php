<?php
declare(strict_types=1);

namespace App\Model;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use JMS\Serializer\Annotation\AccessType;


/** @AccessType("public_method") */
class Scooter
{
    /**
     * @OA\Property(type="string", description="universal id of the scooter")
     * @Serializer\Type("string")
     */
    private $uuid;

    /**
     * @OA\Property(type="boolean", description="status of the fetched scooter")
     * @Serializer\Type("bool")
     */
    private $status;

    /**
     * @OA\Property(type="array", @OA\Items(ref=@Model(type=Location::class)))
     * @Serializer\Type("ArrayCollection<App\Model\Location>")
     */
    private $lastLocations;

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getLastLocations()
    {
        return $this->lastLocations;
    }

    public function setLastLocations($lastLocations): void
    {
        $this->lastLocations = $lastLocations;
    }
}