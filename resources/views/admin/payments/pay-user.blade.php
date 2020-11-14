@extends('dashboard.base')

@section('content')

    @livewireStyles()
    @livewire('create-payment-component')
    @livewireScripts()

@endsection

@section('javascript')
    <script src="/js/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript">
        $("#date").mask("99/99/9999");
    </script>
@endsection
