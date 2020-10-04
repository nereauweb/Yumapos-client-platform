<div>
    @include('livewire.user.approve')
    @include('livewire.user.destroy')
    @if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success') }}
    </div>
    @elseif(session()->has('warning'))
    <div class="alert alert-warning" role="alert">
        {{ session()->get('warning') }}
    </div>
    @elseif(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error') }}
    </div>
    @endif
    <table class="table table-striped table-sm col-filtered-datatable">
        <thead>
            <tr>
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
                            <button class="btn btn-danger" data-toggle="modal" data-target="#modalDelete"
                                wire:click="destroy({{ $user->id }})">{{ __('coreuiforms.delete') }}</button>
                        @endif
                        @if (!$user->state)
                            <button class="btn btn-success" data-toggle="modal" data-target="#modalApprove"
                                wire:click="approve({{ $user->id }})">Approve</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
