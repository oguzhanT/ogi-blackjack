@extends('app')
@section('content')
    <form method="POST" action="{{ route('createNewGame') }}">
        @csrf
        <div>
            <label for="playerName">{{ trans('blackjack.player_name') }}</label>
            <input type="text" id="playerName" name="playerName" value="{{ old('playerName') }}" placeholder="{{ trans('blackjack.player_1') }}">
            <span>{{ $errors->first('playerName') }}</span>
        </div>
        <div>
            <label for="delay">{{ trans('blackjack.delay') }}</label>
            <input type="number" id="delay" name="delay" value="30" placeholder="{{ trans('blackjack.seconds') }}">
            <span>{{ $errors->first('delay') }}</span>
        </div>
        <div>
            <input type="submit" value="{{ trans('blackjack.start') }}"/>
        </div>
    </form>
@endsection
