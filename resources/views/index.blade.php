@extends('layout')

@section('content')
    <div class="container">
        <div class="title-bar">Bolão da Copa</div>

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
                            @if ($user->id == Auth::id())
                                <span><a href="/profile" style="color: #007CFF; text-decoration: none;">{{$user->name}}</a></span>
                            @else
                                <span><a href="/profile/{{$user->id}}">{{$user->name}}</a></span>
                            @endif
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