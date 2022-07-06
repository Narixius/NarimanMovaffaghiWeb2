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

    public static function likelyString(String $str): String {
        return "%".strtolower($str)."%";
    }

    public function search(String $input): iterable
    {
        $hotelRepository = $this->manager->getRepository(Hotel::class);
        return $hotelRepository->createQueryBuilder('hotel')->where('LOWER(hotel.name) like :query')->setParameter('query', $this->likelyString($input))->getQuery()->getResult();
    }
}