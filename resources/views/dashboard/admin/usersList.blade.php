@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@livewireStyles()
@section('content')
    <div id="formData">
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class=" uk-child-width-1-2" uk-grid>
                                    <div>
                                        <h4>{{ __('coreuiforms.users.users') }}</h4>
                                    </div>
                                    <div class="uk-text-right">
                                        <a class="uk-button uk-link-reset btn btn-success" href="/users/create">
                                            Crea nuovo utente
                                        </a>
                                        <a class="uk-button uk-link-reset btn btn-danger" href="/users/deleted">
                                            Utenti eliminati
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @livewire('user')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@livewireScripts()
<script type="text/javascript">
    window.livewire.on('userClose', () => {
        $('#modalDelete').modal('hide');
        $('#modalApprove').modal('hide');
    });
</script>
