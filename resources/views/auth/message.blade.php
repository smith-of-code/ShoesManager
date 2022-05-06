@extends('layouts.auth')
@section('action')
    {{route('auth.signin-form')}}
@endsection

@section('method'){{'get'}}@endsection

@section('form_title')
    {{$message??''}}
@endsection

@section('form_body')
@endsection
@section('button_text')
    Войти
@endsection
