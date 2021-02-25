<?php
namespace App\Library;

class Card
{
    const VALUES =  ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    const IMAGES = ['J','Q','K'];

    const TYPE_HEART = 'H';
    const TYPE_SPADES = 'S';
    const TYPE_DIAMOND = 'D';
    const TYPE_CLUB = 'C';

    const TYPES = [
        self::TYPE_HEART,
        self::TYPE_SPADES,
        self::TYPE_DIAMOND,
        self::TYPE_CLUB,
    ];


    /**
     * @var string
     */
    private $card;

    public function __construct(string $card)
    {
        $this->card = $card;
    }

    public function getValue(): int
    {
        $cardValue = substr($this->card, 1);
        $cardType = substr($this->card, 0, 1);

        if (!in_array($cardType, self::TYPES)) {
            throw new \Exception(trans('blackjack.undefined_card').": {$this->card}");
        }

        if (in_array($cardValue, self::IMAGES) || $cardValue == 10) {
            return 10;
        } elseif (is_numeric($cardValue) && $cardValue >= 2) {
            return (int)$cardValue;
        } elseif ($cardValue === 'A') {
            return  11;
        } else {
            throw new \Exception(trans('blackjack.undefined_card').": {$this->card}");
        }
    }

    public function getString(): string
    {
        return substr($this->card, 1);
    }
}
