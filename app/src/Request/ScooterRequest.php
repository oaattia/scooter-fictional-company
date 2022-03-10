<?php
declare(strict_types=1);

namespace App\Request;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations\Property;
use Symfony\Component\Validator\Constraints as Assert;

/** @Serializer\AccessType("public_method") */
class ScooterRequest
{
    /**
     * @var bool
     * @Property(type="boolean", required={"status"}, description="status of the scooter occupied or not")
     * @Serializer\Type("bool")
     * @Assert\NotNull()
     * @Assert\Type("boolean")
     */
    private $status;

    /**
     * @var \DateTime
     * @Property(type="object", required={"currentDateTime"}, description="current timestamp format d-m-Y H:i:s", format="d-m-Y H:i:s")
     * @Serializer\Type("DateTime<'d-m-Y H:i:s'>")
     * @Assert\NotNull()
     * @Assert\DateTime()
     * @Assert\GreaterThan(value="now")
     */
    private $currentDateTime;

    /**
     * @Property(type="integer", description="longitude for the scooter")
     * @Serializer\Type("integer")
     * @Assert\NotNull()
     * @Assert\Type("int")
     */
    private $longitude;

    /**
     * @Property(type="integer", description="latitude for the scooter")
     * @Serializer\Type("integer")
     * @Assert\NotNull()
     * @Assert\Type("int")
     */
    private $latitude;

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getCurrentDateTime(): \DateTime
    {
        return $this->currentDateTime;
    }

    public function setCurrentDateTime(\DateTime $currentDateTime): void
    {
        $this->currentDateTime = $currentDateTime;
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