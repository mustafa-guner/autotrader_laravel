@component('mail::message')
    # New Feedback Received

    A new feedback has been submitted.

    **User**: {{ $feedback->user->full_name }}
    **Feedback Type**: {{ $feedback->feedbackType->name }}
    **Comment**: {{ $feedback->comment }}
    **Submitted At**: {{ $feedback->created_at }}

@endcomponent
