@extends('layouts.auth')
@section('title')Сброс пароля@endsection

@section('action'){{route('auth.reset-password')}}@endsection

@section('method'){{'post'}}@endsection

@section('form_title')Сброс пароля@endsection

@section('form_body')
    <label class="auth__label auth__label-first"><strong>Email</strong></label>
    <input type="text" placeholder="Введите Email" name="email" required value="{{old('email')}}">
    <p class="auth__error-message">{{$errors->first('email')}}</p>
@endsection

@section('button_text')Отправить ссылку@endsection

@section('form_footer')
    <span><a href="{{route('auth.signin-form')}}"> Войти</a></span>
@endsection
