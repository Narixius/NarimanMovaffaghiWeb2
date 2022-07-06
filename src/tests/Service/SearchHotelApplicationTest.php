<?php

namespace App\Tests\Service;

use App\Entity\Hotel;
use App\Service\SearchHotel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchHotelApplicationTest extends WebTestCase
{
    public function testSomething(): void
    {

        $client = static::createClient();

        // add new hotel
        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        $hotelName = 'Setareh Shomal';
        $hotel = new Hotel();
        $hotel->setName($hotelName);
        $hotel->setStars(5);
        $hotel->setScore(4.9);
        $entityManager->persist($hotel);
        $entityManager->flush();

        $crawler = $client->request('GET', '/hotel/search?q=setareh');

        $name = $crawler->filter('td:contains("Setareh Shomal")');
        $stars = $name->nextAll();
        $score = $stars->nextAll();

        $this->assertResponseIsSuccessful();
        $this->assertEquals($hotelName, $name->innerText());
        $this->assertEquals('5', $stars->innerText());
        $this->assertEquals('4.9', $score->innerText());

        // remove added hotel
        $entityManager->remove($entityManager->getRepository(Hotel::class)->find($hotel->getId()));
        $entityManager->flush();
    }
}
