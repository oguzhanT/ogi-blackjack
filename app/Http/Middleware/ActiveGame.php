<?php

namespace App\Http\Middleware;

use App\Library\Game;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActiveGame
{
    /**
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('activeGame')) {
            return redirect(route('index'));
        }

        $game = Session::get('activeGame');

        if (!$game instanceof Game) {
            return route('index');
        }

        $request->request->add(['game' => $game]);


        return $next($request);
    }
}
