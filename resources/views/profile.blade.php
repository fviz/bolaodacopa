<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>Bolão</title>


</head>
<body>
<div class="container">
    <div class="title-bar">
        <span>Bolão da Copa</span>
        <form action="/" method="get" style="display: inline">
            <button class="normal" type="submit">Voltar</button>
        </form>
    </div>
    <div class="widgets">
        <div class="modal">
            <div class="header">
                <span>ESTATÍSTICAS - {{$user->name}}</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>