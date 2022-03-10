<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Scooter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scooter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scooter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scooter[]    findAll()
 * @method Scooter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScooterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scooter::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Scooter $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Scooter $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function update(Scooter $scooter, bool $status, \DateTime $dateTime, int $longitude, int $latitude): void
    {
        $scooter->setStatus($status);

        $location = new Location();
        $location->setDateTime($dateTime);
        $location->setLongitude($longitude);
        $location->setLatitude($latitude);
        $scooter->addLocation($location);

        $this->_em->persist($location);
        $this->_em->persist($scooter);

        $this->_em->flush();
    }



    public function getScootersMaxLimit(?bool $status, int $limit, int $offset = 0): array
    {
        $query = $this->createQueryBuilder('sc')
            ->select('sc')
            ->setMaxResults($limit)
            ->setFirstResult($offset);


        if ($status !== null) {
            $query->where('sc.status = :status');
            $query->setParameter('status', (int)$status);
        }

        return $query->getQuery()
            ->getResult();
    }
}
