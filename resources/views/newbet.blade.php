@extends('layout')

@section('content')

	<?php
	$teamA = $countries->where('code', $game->teamA)->first();
	$teamB = $countries->where('code', $game->teamB)->first();
	?>

    <div class="container">
        <div class="title-bar">Bolão da Copa</div>
        <div class="widgets">
            <div class="modal">
                <div class="header">
                    <span>NOVA APOSTA</span>
                </div>
                <form class="newbetform">
                    <input id="game_id" type="hidden" value="{{$game->id}}">
                    <div class="newbet">
                        <div class="teamname">{{ $teamA->name }}</div>
                        <div class="teamscore">
                            <div class="buttonplusminus" id="teamAminus"><span>–</span></div>
                            <span id="aScore">0</span>
                            <div class="buttonplusminus" id="teamAplus"><span>+</span></div>
                        </div>
                        <div class="vs">vs.</div>
                        <div class="teamname">{{ $teamB->name }}</div>
                        <div class="teamscore">
                            <div class="buttonplusminus" id="teamBminus"><span>–</span></div>
                            <span id="bScore">0</span>
                            <div class="buttonplusminus" id="teamBplus"><span>+</span></div>
                        </div>
                    </div>


                    <button class="big" id="newbetsubmit">Apostar!</button>
                </form>
            </div>
        </div>
    </div>

@endsection