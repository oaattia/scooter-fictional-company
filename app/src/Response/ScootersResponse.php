<?php
declare(strict_types=1);

namespace App\Response;

use OpenApi\Annotations\Property;
use App\Model\Scooter;

class ScootersResponse extends Success
{
    /**
     * @var Scooter[]
     * @Property(type="array", @OA\Items(ref=@Model(type=Scooter::class)))
     */
    private $scooters = [];

    public function getScooters(): array
    {
        return $this->scooters;
    }

    public function setScooters(array $scooters): void
    {
        $this->scooters = $scooters;
    }
}