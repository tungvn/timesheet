@component('mail::message')

It is the time to submit your timesheet. Go to Timesheet and create your one.

@component('mail::button', ['url' => url('/')])
    Create Your Timesheet
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
