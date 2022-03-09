<?php
declare(strict_types=1);

namespace App\Request;

use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations\Property;
use Symfony\Component\Validator\Constraints as Assert;

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
}