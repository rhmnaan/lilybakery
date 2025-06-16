@component('mail::message')
# OTP Verification

Thank you for registering. Please use the following One-Time Password (OTP) to verify your email address:

**{{ $otp }}**

This OTP will expire in 5 minutes.

If you did not request this, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent