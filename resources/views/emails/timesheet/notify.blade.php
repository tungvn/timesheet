@component('mail::message')

@if($timesheet->isCreated())
A timesheet has been created by {{ $timesheet->getAuthorNameAttribute() }} at {{ $timesheet->created_at }}, please review it at the following link.
@elseif($timesheet->isChanged())
A timesheet has been modified by {{ $timesheet->getAuthorNameAttribute() }} at {{ $timesheet->updated_at }}, please review it at the following link.
@endif

@component('mail::button', ['url' => url('/#/timesheet/' . $timesheet->id)])
    Review Timesheet
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
