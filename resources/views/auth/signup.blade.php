@extends('layouts.auth')
@section('action')
    {{route('auth.signup')}}
@endsection

@section('method'){{'post'}}@endsection

@section('form_title')
    Регистрация
@endsection

@section('form_body')
    <label class="auth__label auth__label-first"><strong>Имя</strong></label>
    <input type="text" placeholder="Введите Имя" name="name" required value="{{old('name')}}">
    <p class="auth__error-message">{{$errors->first('name')}}</p>
    <label class="auth__label "><strong>Email</strong></label>
    <input type="text" placeholder="Введите Email" name="email" required value="{{old('email')}}">
    <p class="auth__error-message">{{$errors->first('email')}}</p>
    <label class="auth__label "><strong>Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password" required>
    <label class="auth__label"><strong>Повторите Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password_confirmation" required>
    <p class="auth__error-message">{{$errors->first('password')}}</p>
    <p class="auth__error-message">{{$errors->first('password_confirmation')}}</p>
    <p class="auth__error-message">{{$errors->first('message')}}</p>
@endsection
@section('button_text')Зарегистрироваться@endsection
@section('form_footer')
    <span><a href="{{route('auth.signin-form')}}"> Войти</a></span>
@endsection
