@extends('emails.layouts.master')

@section('title', 'New Feedback Received')

@section('heading')
    <h1>To whom it may concern,</h1>
@endsection

@section('content')
    <p>You have received <strong>{{ strtoupper($feedback->feedbackType->name) }}</strong> type feedback recently.</p>
    <strong>{{$feedback->user->full_name}}</strong> (member for {{$feedback->user->getMembershipDuration()}}) said:
    <blockquote
        style=" font-size: 13px; padding: .4rem; border-left: 4px solid #ccc; margin: 20px 0;">
        <p>“{{$feedback->comment}}”</p>
        at <strong>{{$feedback->created_at->format('d.m.Y H:i')}}</strong>
    </blockquote>
@endsection

