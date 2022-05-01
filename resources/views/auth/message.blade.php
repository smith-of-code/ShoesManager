@extends('layouts.auth')
@section('action')
@endsection

@section('method'){{'post'}}@endsection

@section('form_title')
@endsection

@section('form_body')
    <h3>{{$message??''}}</h3>
@endsection

@section('button_text')
    <span><a href="{{route('auth.signin-form')}}"> Войти</a></span>
@endsection
