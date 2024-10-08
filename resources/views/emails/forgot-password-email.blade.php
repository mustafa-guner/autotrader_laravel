@extends('emails.layouts.master')

@section('title', 'Reset Password')

@section('heading', '👋 Hi! ' . $password_reset_token->user->firstname)

@section('content')
    <div>
        <p>You recently requested to reset your password for your {{config('app.name')}} account. Use the following code
            to
            reset it. <strong>This code is only valid for the next 24 hours.</strong></p>
        <h2 style="text-align: center">{{$password_reset_token->token}}</h2>
    </div>
@endsection
