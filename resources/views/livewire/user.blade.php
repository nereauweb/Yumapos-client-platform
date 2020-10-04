<div>
    @include('livewire.loader')
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
    <table class="table table-striped table-bordered col-filtered-datatable">
        <thead>
            <tr class="cursorPointer">
                <th wire:click="sortByRelations('company_data.company_name')">
                    <span>{{ __('lists.businessname') }}</span>
                    <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                        </path>
                    </svg>
                </th>
                <th wire:click="sortByRelations('company_data.legal_seat_city')">
                    <span>{{ __('lists.city') }}</span>
                    <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                        </path>
                    </svg>
                </th>
                <th wire:click="sortBy('email')">
                    <span>{{ __('coreuiforms.users.email') }}</span>
                    <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                        </path>
                    </svg>
                </th>
                <th>{{ __('coreuiforms.users.roles') }}</th>
                <th wire:click="sortBy('plafond')">
                    <span>Balance (€)</span>
                    <svg width="20" height="20" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 12a1 1 0 102 0V6.414l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L5 6.414V12zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z">
                        </path>
                    </svg>
                </th>
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
