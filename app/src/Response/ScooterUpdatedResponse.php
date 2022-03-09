<?php
declare(strict_types=1);

namespace App\Response;

use OpenApi\Annotations\Property;

class ScooterUpdatedResponse extends Success
{
    /**
     * @var string
     * @Property(type="string", description="uuid of the updated scooter")
     */
    private $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}