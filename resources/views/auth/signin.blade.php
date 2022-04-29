@extends('layouts.auth')
@dd($errors)
@section('action')
    {{route('auth.signin')}}
@endsection

@section('method'){{'post'}}@endsection

@section('form_title')
    Вход
@endsection

@section('form_body')
    <label for="uname"><strong>Email</strong></label>
    <input type="text" placeholder="Введите Email" name="email" required>
    <label for="psw"><strong>Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password" required>
@endsection

@section('form_footer')
    {{$errors->first()}}
    <label style="padding-left: 15px">
        <input type="checkbox"   name="remember"> Запомнить меня
    </label>
    <span><a href="{{route('auth.reset-password')}}"> Потеряли пароль?</a></span>
@endsection
