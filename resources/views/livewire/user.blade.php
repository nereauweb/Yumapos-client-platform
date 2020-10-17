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
    <div class="uk-padding-small">
        <dl class="row">
            <dt class="col-sm-5">Balance</dt>
            <dd class="col-sm-7">{{ $totalBalance }}&euro;</dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-5">Unapproved users</dt>
            <dd class="col-sm-7">{{ $unapprovedUsers }}</dd>
        </dl>
    </div>
    <table class="table table-striped table-bordered col-filtered-datatable">
        <thead>
            <tr class="cursorPointer">
                <th class="no-search"></th>
                <th wire:click="sortByRelations('ucd.company_name')">
                    <span>{{ __('lists.businessname') }}</span>
                    @if($sortAsc && $sortRelations == 'ucd.company_name')
                        <i class="cil-arrow-bottom"></i>
                    @else
                        <i class="cil-arrow-top"></i>
                    @endif
                </th>
                <th wire:click="sortByRelations('ucd.legal_seat_city')">
                    <span>{{ __('lists.city') }}</span>
                    @if($sortAsc && $sortRelations == 'ucd.legal_seat_city')
                        <i class="cil-arrow-bottom"></i>
                    @else
                        <i class="cil-arrow-top"></i>
                    @endif
                </th>
                <th wire:click="sortBy('email')">
                    <span>{{ __('coreuiforms.users.email') }}</span>
                    @if($sortAsc && $sortField == 'email')
                        <i class="cil-arrow-bottom"></i>
                    @else
                        <i class="cil-arrow-top"></i>
                    @endif
                </th>
                <th>{{ __('coreuiforms.users.roles') }}</th>
                <th wire:click="sortBy('plafond')">
                    <span>Balance (€)</span>
                    @if($sortAsc && $sortField == 'plafond')
                        <i class="cil-arrow-bottom"></i>
                    @else
                        <i class="cil-arrow-top"></i>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
						<div class="btn-group btn-group-xs">
							<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
								{{ $user->id }}
								<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
								<span class="sr-only">
									Actions
								</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right">
								@if (!$user->state)
									<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
										wire:click="approve({{ $user->id }})">Approve</button>
								@endif
								<a href="{{ url('/users/' . $user->id) }}" class="dropdown-item btn-primary">{{ __('coreuiforms.view') }}</a>
								<a href="{{ url('/users/' . $user->id. '/edit') }}" class="dropdown-item btn-success">{{ __('coreuiforms.edit') }}</a>
								@if ($you->id !== $user->id)
									@if ($user->hasrole('user')||$user->hasrole('sales'))
									<a href="{{ url('/users/' . $user->id. '/impersonate') }}" class="dropdown-item btn-warning">Impersonate</a>
									@endif
									<button class="dropdown-item btn-danger" data-toggle="modal" data-target="#modalDelete"
										wire:click="destroy({{ $user->id }})">{{ __('coreuiforms.delete') }}</button>
								@endif
							</div>
						</div>
                    </td>
                    <td>{{ ucfirst($user->company_data->company_name ?? '') }}</td>
                    <td>{{ ucfirst($user->company_data->legal_seat_city ?? '') }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(',', $user->getRoleNames()->toArray()) }}</td>
                    <td>{{ $user->plafond }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
