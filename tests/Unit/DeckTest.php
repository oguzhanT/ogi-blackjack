<?php

namespace Unit;

use App\Library\Deck;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DeckTest extends TestCase
{
    public function testDeckFirstDeal()
    {
        $deck = new Deck(new Collection());
        $playerCards = $deck->takeCard(2);
        $dealerCard = $deck->takeCard(2);
        $this->assertCount(2, $playerCards);
        $this->assertCount(2, $dealerCard);
        $this->assertCount(308, $deck->remainingCards());
    }
}
