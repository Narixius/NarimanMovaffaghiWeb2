<?php

namespace App\Tests\Service;

use App\Entity\Hotel;
use App\Service\SearchHotel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SearchHotelIntegrationTestPhpTest extends KernelTestCase
{
    public function testHotelsCount(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
         /** @var SearchHotel $searchHotel */
         $searchHotel = static::getContainer()->get(SearchHotel::class);

         /** @var Hotel[] $results */
         $results = $searchHotel->search('Setareh Sharh');

         $this->assertEquals(1, count($results));
    }
}
