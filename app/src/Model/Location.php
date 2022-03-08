<?php
declare(strict_types=1);

namespace App\Model;

use OpenApi\Annotations as OA;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;


/** @AccessType("public_method") */
class Location
{
    /**
     * @OA\Property(type="string", description="date and time for the last location regisitered for the scooter.")
     * @Type("DateTime")
     */
    private $datetime;

    /**
     * @OA\Property(type="integer", description="longitude for the scooter")
     * @Type("int")
     */
    private $longitude;

    /**
     * @OA\Property(type="integer", description="latitude for the scooter")
     * @Type("int")
     */
    private $latitude;

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime): void
    {
        $this->datetime = $datetime;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }
}