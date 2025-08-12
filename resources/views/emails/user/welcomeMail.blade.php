@component('mail::message')
Dear User,

Welcome to Events!

We are pleased to inform you that your account has been successfully created.

# To login to the portal, please reset your password by clicking on the link below.

@component('mail::button', ['url' => route('password.reset', $token)])
Reset Password
@endcomponent

<br>

Best regards,<br>
Your Events Team!

@endcomponent