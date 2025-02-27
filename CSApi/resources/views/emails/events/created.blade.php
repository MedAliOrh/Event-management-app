@component('mail::message')
# New Event Created

A new event has been created with the following details:

**Title:** {{ $event->title }}  
**Description:** {{ $event->description }}  
**Location:** {{ $event->location }}  
**Date:** {{ $event->date->format('Y-m-d H:i') }}  
**Maximum Participants:** {{ $event->max_participants }}

@component('mail::button', ['url' => url('/events/' . $event->id)])
View Event
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent 