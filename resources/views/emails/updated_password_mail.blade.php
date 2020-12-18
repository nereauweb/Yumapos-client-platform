@component('mail::message')
# Password Updated

Your password has been changed through admin:<br>
# email: {{ $user->email }}<br>
# password: {{ $password }}<br>

# use those credentials login

@component('mail::button', ['url' => 'http://test.yumapos.it/login'])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
