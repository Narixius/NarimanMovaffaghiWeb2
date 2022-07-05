<?php

namespace App\Tests\Service;

use App\Service\SearchHotel;
use PHPUnit\Framework\TestCase;

class SearchHotelUnitTest extends TestCase
{
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function randomStrings() {
        $strings = [];
        for($i = 0; $i < 1000; $i++){
            $strings[] = [$this->generateRandomString()];
        }
        return $strings;
    }

    /**
     * @dataProvider randomStrings
     */
    public function testSearchLikelyString($str)
    {
        $this->assertEquals("%".$str."%", SearchHotel::likelyString($str));
    }
}
