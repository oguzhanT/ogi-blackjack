<?php
namespace App\Library;

use Illuminate\Support\Collection;

class Deck
{
    const NUMBER_OF_DECK = 6;
    const TOTAL_CARD_COUNT = 312;
    const MIN_REMANING_CARD_PERCANTAGE = 0.5;

    /**
     * @var Collection
     */
    private $deck;

    public function __construct(Collection $deck)
    {
        $this->deck = $deck;
        if ($deck->count() === 0) {
            $this->deck = self::newDeck();
        }
    }

    private function newDeck(): Collection
    {
        $cards = [];
        for ($i=0; $i < self::NUMBER_OF_DECK; $i++) {
            foreach (Card::TYPES as $type) {
                foreach (Card::VALUES as $value) {
                    $cards[] = $type.$value;
                }
            }
        }
        $this->deck = collect($cards)->shuffle();

        return  $this->deck;
    }

    public function takeCard(int $number): Collection
    {
        $cards = $this->deck->take($number);

        $this->deck->forget($cards->keys()->all());
        return $cards;
    }

    public function remainingCards(): Collection
    {
        return $this->deck->values();
    }

    public function checkRemainingCardCount(): bool
    {
        $count = $this->deck->count();
        if ((self::TOTAL_CARD_COUNT * self::MIN_REMANING_CARD_PERCANTAGE) > $count) {
            return false;
        }
        return true;
    }
}
