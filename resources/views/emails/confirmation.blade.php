@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => isset($context_url) ? $context_url : config('app.url'), 'name' => isset($context) ? $context : config('app.name')])
@endcomponent
@endslot

{{-- Body --}}

# Attivazione servizi

Gentile cliente,<br>
con la presente email le inviamo le credenziali che potrà usare per accedere al servizio {{ isset($context_title) ? $context_title : config('app.name') }}:

# email: {{ $user->email }}<br>
# password: {{ $password }}<br>

Le basterà cliccare sul pulsante Login per cominciare ad utilizzare i nuovi servizi gratuiti.

@component('mail::button', ['url' => isset($context_url) ? $context_url.'/login' : url('/login') ])
Login
@endcomponent

Grazie,<br>
{{ isset($context_title) ? $context_title : config('app.name') }}

{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
	<!-- subcopy here -->
@endcomponent
@endslot


{{-- Footer --}}
@slot('footer')
@component('mail::footer', ['name' => isset($context) ? $context : config('app.name')])
@endcomponent
@endslot
@endcomponent

