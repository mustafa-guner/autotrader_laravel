@extends('emails.layouts.master')

@section('title', 'Reset Password')

@section('heading')
    <h1>Hi!,</h1>
@endsection

@section('content')
    <div>
        <p>You recently requested to reset your password for your {{config('app.name')}} account. Use the following code
            to
            reset it. <strong>This password reset is only valid for the next 24 hours.</strong></p>
        <h2 style="text-align: center">{{$token}}</h2>
    </div>
@endsection
