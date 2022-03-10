<?php

namespace App\Entity;

use App\Repository\ScooterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=ScooterRepository::class)
 *
 * @Table(name="scooter",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="uuid_scooter_idx",
 *            columns={"uuid"})
 *    }
 * )
 */
class Scooter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Exclude()
     */
    private $id;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="scooter")
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setScooter($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getScooter() === $this) {
                $location->setScooter(null);
            }
        }

        return $this;
    }
}
