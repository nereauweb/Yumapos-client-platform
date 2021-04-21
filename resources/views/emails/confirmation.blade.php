@component('mail::message')
# Email confirmation

Data to use for login:<br>
# email: {{ $user->email }}<br>
# password: {{ $password }}<br>

# use those credentials login

@component('mail::button', ['url' => url('/login'))
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
