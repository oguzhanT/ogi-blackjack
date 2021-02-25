<?php

namespace Unit;

use App\Library\Card;
use Tests\TestCase;

class CardTest extends TestCase
{
    public function testValidValues()
    {
        foreach (['H', 'S', 'D', 'C'] as $type) {
            foreach (['J','Q','K'] as $face) {
                $card = new Card("{$type}{$face}");
                $this->assertEquals(10, $card->getValue(), "Using {$type}{$face}");
            }
            foreach ([2, 3, 4, 5, 6, 7, 8, 9, 10] as $value) {
                $card = new Card("{$type}{$value}");
                $this->assertEquals($value, $card->getValue(), "Using {$type}{$value}");
            }
        }
    }
}
