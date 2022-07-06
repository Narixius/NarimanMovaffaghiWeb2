<?php

namespace App\Tests\Service;

use App\Entity\Hotel;
use App\Service\SearchHotel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SearchHotelIntegrationTestPhpTest extends KernelTestCase
{
    public function testHotelsCount(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
         /** @var SearchHotel $searchHotel */
         $searchHotel = static::getContainer()->get(SearchHotel::class);

         /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()->get('doctrine')->getManager();

        /** @var Hotel[] $results */
         $results = $searchHotel->search('setareh');
         $this->assertEquals(1, count($results));

         $hotel = new Hotel();
         $hotel->setName('Setareh Shomal');
         $hotel->setScore(4.9);
         $hotel->setStars(5);

         $entityManager->persist($hotel);
         $entityManager->flush();

        /** @var Hotel[] $results */
        $results = $searchHotel->search('setareh');
        $this->assertEquals(2, count($results));

        $entityManager->remove($entityManager->getRepository(Hotel::class)->find($hotel->getId()));
        $entityManager->flush();
    }
}
