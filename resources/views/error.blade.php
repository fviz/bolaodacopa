@extends('layout')

@section('content')
    <div class="container">
        <div class="title-bar">
            <span>Bolão da Copa</span>
            <form action="/" method="get" style="display: inline">
                <button class="normal" type="submit">Voltar</button>
            </form>
        </div>

        <div class="errormodal">
			<?php $user = Auth::user() ?>
            <div class="modal">
                <div class="header">
                    <span>ERRO</span>
                </div>
                <div class="modal-content">
                    {{$error}}. <a href="/profile/{{$user->id}}"><b>Voltar.</b></a>
                </div>
            </div>
        </div>
@endsection