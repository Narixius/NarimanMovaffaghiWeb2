<?php

namespace App\Service;

use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;

class SearchHotel
{

    private EntityManagerInterface $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function search(String $input): iterable
    {
        $hotelRepository = $this->manager->getRepository(Hotel::class);
        return $hotelRepository->createQueryBuilder('hotel')->where('hotel.name like :query')->setParameter('query', "%".$input."%" )->getQuery()->getResult();
    }
}