<?php
namespace App\Library;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Game
{
    const BLACKJACK = 21;
    const DEALER_MAX_HIT_NUMBER = 17;

    /**
     * @var array
     */
    public $player;
    /**
     * @var array
     */
    public $dealer;
    /**
     * @var Deck
     */
    protected $deck;
    /**
     * @var array
     */
    private $config;
    /**
     * @var int
     */
    public $delay;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var array
     */
    public $winnerHand = [];
    /**
     * @var int
     */
    protected $playerHandTotal = 0;
    /**
     * @var int
     */
    protected $dealerHandTotal = 0;


    public function __construct(array $config)
    {
        $this->config = $config;
        self::newGame();
    }

    private function newGame(): self
    {
        $this->deck = new Deck(new Collection());
        $this->id = Str::random();
        $this->delay = $this->config['delay'];
        $this->player = ['name' => $this->config['playerName'], 'hand' => $this->deck->takeCard(2)->values()];

        $this->dealer = ['name' => 'Dealer', 'hand' => $this->deck->takeCard(2)->values()];
        self::getDealerHandTotal();
        self::getPlayerHandTotal();
        $this->checkBlackjack();
        Session::put('activeGame', $this);
        return $this;
    }

    public function hit(): void
    {
        $hand = $this->player['hand'];
        $card = $this->deck->takeCard(1);
        $this->player['hand'] = $hand->push($card->first())->values();

        self::getPlayerHandTotal();

        $this->checkBlackjack();
    }

    public function stand(): void
    {
        $this->dealerDecision();
        $this->checkBlackjack();
        if (empty($this->winnerHand)) {
            $this->setWinner();
        }
    }

    public function newRound(): void
    {
        if (!$this->deck->checkRemainingCardCount()) {
            $this->deck = new Deck(new Collection());
        }

        $this->player = ['name' => $this->config['playerName'], 'hand' => $this->deck->takeCard(2)->values()];
        $this->dealer = ['name' => 'Dealer', 'hand' => $this->deck->takeCard(2)->values()];
        self::getDealerHandTotal();
        self::getPlayerHandTotal();
        $this->winnerHand = [];

        $this->checkBlackjack();
    }

    public function dealerDecision(): void
    {
        $hand = $this->dealer['hand'];
        if ($this->dealerHandTotal < self::DEALER_MAX_HIT_NUMBER) {
            $card = $this->deck->takeCard(1);
            $this->dealer['hand'] = $hand->push($card->first())->values();
            self::getDealerHandTotal();
            self::dealerDecision();
        }
        $this->checkBlackjack();
    }

    private function getPlayerHandTotal(): void
    {
        $hand = $this->player['hand'];

        $this->playerHandTotal = 0;

        foreach ($hand as $item) {
            $card = new Card($item);
            if ($this->playerHandTotal > 10 && $card->getString() === 'A') {
                $this->playerHandTotal += 1;
            } else {
                try {
                    $this->playerHandTotal += $card->getValue();
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    abort(500);
                }
            }
        }
    }

    public function getDealerHandTotal(): void
    {
        $hand = $this->dealer['hand'];

        $this->dealerHandTotal = 0;

        foreach ($hand as $item) {
            $card = new Card($item);

            if ($this->dealerHandTotal > 10 && $card->getString() === 'A') {
                $this->dealerHandTotal += 1;
            } else {
                try {
                    $this->dealerHandTotal += $card->getValue();
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    abort(500);
                }
            }
        }
    }

    public function checkBlackjack(): bool
    {
        if ($this->dealerHandTotal > Game::BLACKJACK) {
            $this->winnerHand = $this->player;
        } elseif ($this->playerHandTotal > Game::BLACKJACK) {
            $this->winnerHand = $this->dealer;
        } elseif ($this->playerHandTotal === Game::BLACKJACK && $this->dealerHandTotal != Game::BLACKJACK) {
            $this->winnerHand = $this->player;
            return true;
        } elseif ($this->playerHandTotal != Game::BLACKJACK && $this->dealerHandTotal === Game::BLACKJACK) {
            $this->winnerHand = $this->dealer;
            return true;
        } elseif ($this->playerHandTotal === Game::BLACKJACK && $this->dealerHandTotal === Game::BLACKJACK) {
            $this->winnerHand = ['Draw' => true, 'hand' => $this->dealer['hand']];
            return true;
        }
        return false;
    }

    public function setWinner():void
    {
        if ($this->dealerHandTotal > $this->playerHandTotal) {
            $this->winnerHand = $this->dealer;
        } elseif ($this->dealerHandTotal < $this->playerHandTotal) {
            $this->winnerHand = $this->player;
        } else {
            $this->winnerHand = ['Draw' => true, 'hand' => $this->dealer['hand']];
        }
    }
}
