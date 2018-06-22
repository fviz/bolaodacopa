@extends('layout')

@section('content')

    <div class="container">
        <div class="title-bar">
            <span>Bolão da Copa</span>
            <form action="/" method="get" style="display: inline">
                <button class="normal" type="submit">Voltar</button>
            </form>
        </div>

        <div class="apitest">
			<?php $user = Auth::user() ?>
            <div class="modal">
                <div class="header">
                    <span>API TEST</span>
                </div>
                <div class="modal-content">

					<?php
					$json = file_get_contents('https://api.fifa.com/api/v1/calendar/matches?idseason=254645&idcompetition=17&language=en-GB&count=100');
					$obj = json_decode($json);
					?>

                </div>
            </div>
        </div>

    </div>

@endsection