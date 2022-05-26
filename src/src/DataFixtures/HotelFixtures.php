<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HotelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//         $product = new Product();
//         $manager->persist($product);


        $hotel = new Hotel();
        $hotel->setName("Setareh Sharh");
        $hotel->setScore(4.3);
        $hotel->setStars(4);

        $room = new Room();
        $room->setBedCount(2);
        $room->setIsEmpty(false);
        $room->setHotel($hotel);

        $manager->persist($hotel);
        $manager->persist($room);

        $manager->flush();
    }
}
