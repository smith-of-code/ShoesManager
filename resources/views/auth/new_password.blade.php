
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>shoes manager</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>
<body>
<form action="{{route('password.reset')}}" method="post">
    <input type="hidden" name="token" value="{{$token}}">
    <label> email<input type="text" name="email"></label>
    <label> Новый пароль<input type="text" name="password"></label>
    <label> Новый пароль еще раз<input type="text" name="password_confirmation"></label>
    <input type="submit">
</form>
</body>
</html>
