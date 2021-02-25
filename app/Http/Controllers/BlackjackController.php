<?php
namespace App\Http\Controllers;

use App\Http\Requests\BlackjackRequest;
use App\Library\Game;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class BlackjackController extends Controller
{
    public function __construct()
    {
        $this->middleware('activeGame')->except(['index','create']);
    }

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response|View
     */
    public function index()
    {
        return view('blackjack.new_game');
    }

    public function create(BlackjackRequest $request): RedirectResponse
    {
        $config = $request->validated();
        Session::forget('activeGame');
        new Game($config);

        return redirect(route('game'));
    }

    /**
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response|View
     */
    public function show(Request $request)
    {
        $game = $request->get('game');

        $winnerHand = $game->winnerHand;

        return view('blackjack.game', ['game' => $game, 'winnerHand' => $winnerHand]);
    }

    public function stand(Request $request): RedirectResponse
    {
        $game = $request->get('game');
        $game->stand();

        return redirect(route('game'));
    }

    public function hit(Request $request): RedirectResponse
    {
        $game = $request->get('game');
        $game->hit();

        return redirect(route('game'));
    }

    public function newRound(Request $request): RedirectResponse
    {
        $game = $request->get('game');
        $game->newRound();

        return redirect(route('game'));
    }
}
