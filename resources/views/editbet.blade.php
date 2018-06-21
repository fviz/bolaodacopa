@extends('layout')

@section('content')
	<?php
	$teamA = $countries->where('code', $bet->game->teamA)->first();
	$teamB = $countries->where('code', $bet->game->teamB)->first();
	?>

    <div class="container">
        <div class="title-bar">Bolão da Copa</div>
        <div class="widgets">
            <div class="modal">
                <div class="header">
                    <span>ALTERAR APOSTA</span>
                </div>
                <form class="newbetform">
                    <input id="game_id" type="hidden" value="{{$bet->game->id}}">
                    <input id="bet_id" type="hidden" value="{{$bet->id}}">
                    <div class="newbet">
                        <div class="teamname">{{ $teamA->name }}</div>
                        <div class="teamscore">
                            <div class="buttonplusminus" id="teamAminus"><span>–</span></div>
                            <span id="aScore">{{$bet->aScore}}</span>
                            <div class="buttonplusminus" id="teamAplus"><span>+</span></div>
                        </div>
                        <div class="vs">vs.</div>
                        <div class="teamname">{{ $teamB->name }}</div>
                        <div class="teamscore">
                            <div class="buttonplusminus" id="teamBminus"><span>–</span></div>
                            <span id="bScore">{{$bet->bScore}}</span>
                            <div class="buttonplusminus" id="teamBplus"><span>+</span></div>
                        </div>
                    </div>


                    @if(gmdate("U") * 1000 < $bet->game->date)
                        <button class="big" id="editbetsubmit">Alterar!</button>
                    @else
                        <span>O jogo já começou. Você não pode alterar sua aposta. <a href="/">Voltar.</a><br><br></span>
                    @endif

                </form>
            </div>
        </div>
    </div>
@endsection