@extends('layout')

@section('content')
    <div class="container">
        <div class="title-bar">
            <span>Bolão da Copa</span>
            <form action="/" method="get" style="display: inline">
                <button class="normal" type="submit">Voltar</button>
            </form>
        </div>

        {{-- EDIT PROFILE SECTION--}}
        @if(Auth::user() == $tuser)
            <div class="editprofile">
				<?php $user = Auth::user() ?>
                <div class="modal">
                    <div class="header">
                        <span>EDITAR PERFIL</span>
                    </div>
                    <form action="/profile/edit" method="post" style="padding-bottom: 16px;">
                        Nome<br>
                        <input type="text" class="editprofileinput" name="name" value="{{$user->name}}"><br>
                        <br>
                        PIN
                        <input type="password" class="editprofileinput" name="pin" value="{{$user->password}}"><br/>
                        <button type="submit" class="normal">Salvar</button>
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        @endif

        {{-- STATS SECTION --}}
        <div class="stats">
			<?php
			$user = $tuser;
			?>
            <div class="modal">
                <div class="header">
                    <span>{{$user->name}}</span>
                </div>
                <div style="padding-left: 24px; padding-right: 24px; padding-bottom: 16px">
                    <span class="stattitle">Pontuação</span><br><span class="statbig">{{$user->score}}</span><br><br>
                    <span class="stattitle">APOSTAS</span><br><br>
                    @foreach($user->bets as $bet)
                        @if($bet->game->isDone())
							<?php
							$teamA = App\Country::where('code', $bet->game->teamA)->first();
							$teamB = App\Country::where('code', $bet->game->teamB)->first();
							$game = $bet->game;
							?>
                            <div class="game">
                                <div class="timedate">
                                    <span>{{date("d/m - gA", strtotime($bet->game->date))}}</span>
                                </div>
                                <div class="team">
                                    <img src="/flags/{{$teamA->code}}.svg">
                                    <span>{{$teamA->name}}</span>
                                </div>
                                <div class="team">
                                    <img src="/flags/{{$teamB->code}}.svg">
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
                                        <div class="bet_display_profile" data-bet_id="{{$thisbet->id}}">
                                            {{ $thisbet->aScore }} : {{ $thisbet->bScore }}
                                        </div>
                                    @endif
                                </div>
                                <div class="hint pointsreceived">
                                    <b>+ {{ $bet->pointsreceived }} PTS</b>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="hint">As apostas aparecerão aqui ao final do jogo.</div>
                </div>
            </div>
        </div>

    </div>

    </div>
@endsection