@extends('app')
@section('content')
    <div class="table">
        @if (empty($winnerHand))
            <strong>{{ trans('blackjack.remaining_time') }}</strong>  <span id="timer"></span>
        @endif

        <div class="player" id="dealer">
            <h4>{{ $game->dealer['name'] }}</h4>
            <div>
                @foreach($game->dealer['hand'] as $key => $item)
                    @if (empty($winnerHand) && $key == 0)
                        <span class="card">X</span>
                    @else
                        <span class="card">{{ $item }}</span>
                    @endif

                @endforeach
            </div>
        </div>

        <div class="player" id="player">
            <h4>{{ $game->player['name'] }}</h4>

            <div>
                @foreach($game->player['hand'] as $item)
                    <span class="card">{{ $item }}</span>
                @endforeach
            </div>
        </div>

        <div>
            <form action="" method="POST">
                {{ csrf_field() }}
                @if ($winnerHand)
                    <div class="winner">
                        @if (!isset($winnerHand['status']))
                            winner "{{ $winnerHand['name'] }}"
                        @else
                            Draw
                        @endif
                        @foreach($winnerHand['hand'] as $item)
                            <span>{{ $item }}</span>
                        @endforeach</div>
                    <button type="submit" name="newRound" class="button-new-round" id="newRound" formaction="{{route('newRound')}}"> New Round </button>
                @else
                    <button type="submit" name="hit" class="button-hit" id="hit" formaction="{{route('hit')}}"> Hit </button>
                    <button type="submit" name="stand" class="button-stand" id="stand" formaction="{{route('stand')}}"> Stand </button>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('footer')
    @if (empty($winnerHand))
        <script>
            $(document).ready(function(){
                $('#timer').timer([0, {{$game->delay}}], function(){
                    $('#stand').click();
                });
            });
        </script>
    @endif
@endsection
