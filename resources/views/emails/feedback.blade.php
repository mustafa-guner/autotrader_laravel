@extends('emails.layouts.master')

@section('title', 'New Feedback Received')

@section('heading','To whom it may concern,')

@section('content')
    <p>You have received <strong>{{ strtoupper($feedback->feedbackType->name) }}</strong> type feedback recently.</p>
    <p><strong>{{$feedback->user->full_name}}</strong> said:
    </p>
    <blockquote
        style=" font-size: 13px; padding: .4rem; border-left: 4px solid #ccc; margin: 20px 0;">
        <p>“{{$feedback->comment}}”</p>
        at <strong>{{$feedback->created_at->format('d.m.Y H:i')}}</strong>
    </blockquote>
@endsection

