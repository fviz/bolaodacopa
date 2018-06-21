<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bolão</title>

    <link rel="stylesheet" href="css/app.css">

</head>
<body>
<div class="container">
    <div class="title-bar">Bolão da Copa</div>
    <div class="widgets">
        <div class="modal" id="loginmodal">
            <div class="header">
                <span>Login</span>
            </div>
            <div class="logindiv">
                <form action="/login" method="POST">
                    {{ csrf_field() }}
                    <input type="tel" name="pin">
                    <button type="submit" class="normal">Entrar!</button>
                    @if (isset($message))
                        <div class="errormessage">{{$message}}</div>
                    @endif
                </form>
            </div>



        </div>
    </div>
</div>
</body>
</html>