@component('mail::message')
# Introduction

Hello {{$name}},

The body of your message.

@component('mail::button', ['url' => $link])
    Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
