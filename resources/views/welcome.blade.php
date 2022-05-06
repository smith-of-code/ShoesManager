<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>shoes manager</title>
<link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>
<body>
<script>window.isAuth = {{Auth::check()?"true":"false"}}</script>
<div id="app"></div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>
