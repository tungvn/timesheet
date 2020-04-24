@component('mail::message')

    A timesheet has been created by {{ $timesheet->getAuthorNameAttribute() }} at {{ $timesheet->created_at }}, please review it at the following link.

    @component('mail::button', ['url' => url('/#/timesheet/' . $timesheet->id)])
        Review Timesheet
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
