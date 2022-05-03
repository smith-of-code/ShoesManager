@extends('layouts.auth')
@section('action')
    {{route('password.reset')}}
@endsection

@section('method'){{'post'}}@endsection

@section('form_title')
    Новый пароль
@endsection

@section('form_body')
    <input type="hidden" name="token" value="{{$token}}">
    <input type="hidden" name="email" value="{{$email}}">
    <label class="auth__label auth__label-first"><strong>Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password" required>
    <label class="auth__label"><strong>Повторите Пароль</strong></label>
    <input type="password" placeholder="Введите пароль" name="password_confirmation" required>
    <p class="auth__error-message">{{$errors->first('password')}}</p>
    <p class="auth__error-message">{{$errors->first('password_confirmation')}}</p>
    <p class="auth__error-message">{{$errors->first('message')}}</p>
@endsection
@section('button_text')Сохранить@endsection
@section('form_footer')
@endsection
