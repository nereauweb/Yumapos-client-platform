@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')
    <div id="formData">
        <div class="container-fluid">
            <div class="animated fadeIn">
              @if (session()->has('status'))
                <div class="alert @if(session()->get('status') == 'success') alert-success @else alert-danger @endif" role="alert">
                  {{ session()->get('message') }}
                </div>
              @endif
                <div class="row">
                    <div class="">
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
                                <table class="table table-striped table-sm col-filtered-datatable">
                                    <thead>
                                        <tr>
                                            {{-- <th>{{ __('coreuiforms.users.username') }}
                                            </th>
                                            --}}
                                            <th>{{ __('lists.businessname') }}</th>
                                            <th>{{ __('lists.city') }}</th>
                                            <th>{{ __('coreuiforms.users.email') }}</th>
                                            <th>{{ __('coreuiforms.users.roles') }}</th>
                                            <th>Balance (€)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                {{-- <td>{{ $user->name }}</td>
                                                --}}
                                                <td>{{ ucfirst($user->company_data->company_name ?? '') }}</td>
                                                <td>{{ ucfirst($user->company_data->legal_seat_city ?? '') }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ implode(',', $user->getRoleNames()->toArray()) }}</td>
                                                <td>{{ $user->plafond }}</td>
                                                <td>
                                                    <a href="{{ url('/users/' . $user->id) }}"
                                                        class="btn btn-primary">{{ __('coreuiforms.view') }}</a>
                                                    <a href="{{ url('/users/' . $user->id . '/edit') }}"
                                                        class="btn btn-primary">{{ __('coreuiforms.edit') }}</a>
                                                    @if ($you->id !== $user->id)
                                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                            style="display:inline-block">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                class="btn btn-danger">{{ __('coreuiforms.delete') }}</button>
                                                        </form>
                                                    @endif
                                                    @if (!$user->state)
                                                        <button class="btn btn-success" data-toggle="modal"
                                                            data-target="#modalApprove"
                                                            @click="getUser({{ $user }})">Approve</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="modalApproveTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalApproveTitle">Approve user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form ref="form" @submit.prevent="validate" :action="formPath" method="POST" id="approvalForm">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group has-feedback row">
                                <label for="parent_percent" class="col-md-3 control-label">Percentuale referente</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input id="parent_percent" class="form-control" placeholder="Percentuale referente"
                                            min="0" step="0.01" name="parent_percent" type="number" v-model="percentage">
                                        <div class="input-group-append">
                                            <label for="parent_percent" class="input-group-text">
                                                %
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback row ">
                                <label for="group" class="col-md-3 control-label">Ruolo utente</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" name="group" id="group">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="group">
                                                <i class="fa fa-fw fa-shield" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        new Vue({
            el: '#formData',
            data() {
                return {
                    user: '',
                    formPath: '',
                    percentage: '',
                }
            },
            methods: {
                getUser(user) {
                    this.user = user;
                    this.formPath = `/admin/user/approve/${this.user.id}`;
                },
                validate(data) {
                    if (this.percentage !== '') {
                        this.$refs.form.submit();
                    } else {
                        alert('fill first the percentage!');
                    }
                }
            }
        });

    </script>
@endsection
