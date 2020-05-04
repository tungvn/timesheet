@component('mail::message')

It's over time to submit your timesheet. Go to Timesheet and create additional your one.

@component('mail::button', ['url' => url('/')])
    Create Your Timesheet
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
