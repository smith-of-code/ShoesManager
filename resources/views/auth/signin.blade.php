@extends('layouts.auth')

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
    <p class="auth__error-message">{{$errors->first('email')}}</p>
    <label for="psw"><strong>Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password" required>
    <p class="auth__error-message">{{$errors->first('password')}}</p>
    <p class="auth__error-message">{{$errors->first('message')}}</p>
@endsection

@section('button_text')Войти@endsection

@section('form_footer')
{{--    <label style="padding-left: 15px">--}}
{{--        <input type="checkbox"   name="remember"> Запомнить меня--}}
{{--    </label>--}}
    <span><a href="{{route('auth.signup')}}"> Нет аккаунта?</a></span>
    <span><a href="{{route('auth.reset-password')}}"> Потеряли пароль?</a></span>
@endsection
