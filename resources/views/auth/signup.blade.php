@extends('layouts.auth')

@section('action')
    {{route('auth.signup')}}
@endsection

@section('method'){{'post'}}@endsection

@section('form_title')
    Регистрация
@endsection

@section('form_body')
    <label for="uname"><strong>Имя</strong></label>
    <input type="text" placeholder="Введите Имя" name="name" required>
    <label for="uname"><strong>Email</strong></label>
    <input type="text" placeholder="Введите Email" name="email" required>
    <label for="psw"><strong>Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password" required>
    <label for="psw"><strong>Повторите Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password_confirmation" required>
@endsection

@section('form_footer')
    <label style="padding-left: 15px">
    </label>
    <span><a href="{{route('auth.signin-form')}}"> Войти</a></span>
@endsection
