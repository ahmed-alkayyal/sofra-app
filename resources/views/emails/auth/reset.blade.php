@component('mail::message')
# Introduction

The body of your message.
{{--
@component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}
<p> this bin code is:{{$code}} </p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
