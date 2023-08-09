<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="'https://google.com'">
Verify E-mail
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
