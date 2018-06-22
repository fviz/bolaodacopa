@extends('layout')

@section('content')
    <div class="container">
        <div class="title-bar">
            <span>Bolão da Copa</span>
            <form action="/" method="get" style="display: inline">
                <button class="normal" type="submit">Voltar</button>
            </form>
        </div>

        <div class="next-games">
            <div class="modal">
                <div class="header">
                    <span>PRÓXIMOS JOGOS</span>
                </div>
                <div class="game-list">

                    @foreach($games as $game)
                        @if($game->finished == false)

							<?php
							$teamA = $countries->where('code', $game->teamA)->first();
							$teamB = $countries->where('code', $game->teamB)->first();
							?>
                            <div class="game">
                                <div class="timedate">
                                    <span>{{date("d/m - gA", strtotime($game->date))}}</span>
                                </div>
                                <div class="team">
                                    <img src="flags/{{$teamA->code}}.svg">
                                    <span>{{$teamA->name}}</span>
                                </div>
                                <div class="team">
                                    <img src="flags/{{$teamB->code}}.svg">
                                    <span>{{$teamB->name}}</span>
                                </div>
                                <div class="actions">
									<?php
									$thisbet = $game->bets->where('user_id', Auth::id())->first();
									?>
                                    @if(count($thisbet) < 1)
                                        @if (time() < strtotime($game->date))
                                            <form action="/games/{{$game->id}}">
                                                <button type="submit" class="normal newbetbutton"
                                                        data-game_id="{{$game->id}}">
                                                    Fazer aposta
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="betdisplaylabel">Sua aposta</div>
                                        <div class="bet_display" data-bet_id="{{$thisbet->id}}">
                                            {{ $thisbet->aScore }} : {{ $thisbet->bScore }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


            </div>
        </div>

        <div class="widgets">
            <div class="modal">
                <div class="header">
                    <span>Placar</span>
                </div>
                <div class="scoreboard">
                    @foreach($users as $key=>$user)
                        <div class="score">
                                <div class="place">{{$key+1}}</div>
                                <a href="/profile/{{$user->id}}">
                                @if ($user->id == Auth::id())
                                    <span style="color: #007CFF; text-decoration: none;">{{$user->name}}</span>
                                @else
                                    <span>{{$user->name}}</span>
                                @endif
                                </a>
                            <span>{{$user->score}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <form action="/logout">
            <button type="submit" class="normal" style="float: right">Logout</button>
        </form>

    </div>
@endsection