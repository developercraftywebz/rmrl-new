@component('mail::message')

# Hello, {{ $body['name'] }}!

## Forgot Your Password?
<br />

That's okay, it happens! Enter this OTP in your mobile application to update password.
<br />

# {{ $body['otp'] }}
<br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
