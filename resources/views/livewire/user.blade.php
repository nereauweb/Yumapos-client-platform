<div>
    @include('livewire.loader')
    @include('livewire.user.approve')
    @include('livewire.user.destroy')
    <div class="uk-padding-small">
        <dl class="row">
            <div class="col-6 row justify-content-between">
                <dt class="col-sm-5">{{ trans('titles.total-balance') }}</dt>
                <dd class="col-sm-7">{{ $totalBalance }}&euro;</dd>
                <dt class="col-sm-5">{{ trans('titles.users-with-positive-balance') }}</dt>
                <dd class="col-sm-7">{{ $positiveBalance }}&euro;</dd>
                <dt class="col-sm-5">{{ trans('titles.users-with-negative-balance') }}</dt>
                <dd class="col-sm-7">{{ $negativeBalance }}&euro;</dd>
            </div>
            <div class="col-6">
                <label for="search">{{ trans('titles.search-by-em-or-sr') }}</label>
                <div class="input-group mb-3">
                    <input wire:model.defer="searchInput" type="text" class="form-control" placeholder="Email or Ragione sociale" aria-label="Email or Ragione sociale" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button wire:click="search" class="btn btn-primary" type="button">{{ trans('titles.search') }}</button>
                    </div>
                </div>
            </div>
        </dl>
        <dl class="row align-items-center">
            <div class="col-6 row justify-content-between">
                <dt class="col-sm-5">{{ trans('titles.pending-users') }}</dt>
                <dd class="col-sm-7"><span class="badge-warning rounded px-3 py-1">{{ $unapprovedUsers }}</span></dd>
                <dt class="col-sm-5">{{ trans('titles.rejected-users') }}</dt>
                <dd class="col-sm-7"><span class="badge-danger rounded px-3 py-1">{{ $trashedUsers }}</span></dd>
                <dt class="col-sm-5">{{ trans('titles.approved-users') }}</dt>
                <dd class="col-sm-7"><span class="badge-success rounded px-3 py-1">{{ $approvedUsers }}</span></dd>
            </div>
        </dl>
    </div>
    <div class="mb-4 row align-items-end">
        <div class="col">
            <label for="type_of_select">{{ trans('titles.filter-users-state') }}</label>
            <select wire:model.defer="stateUserSelected" class="custom-select">
                <option selected value="null">{{ trans('titles.all-users') }}</option>
                <option value="1">{{ trans('titles.approved-users') }} ({{ $approvedUsers }})</option>
                <option value="2">{{ trans('titles.rejected-users') }} ({{ $trashedUsers }})</option>
                <option value="3">{{ trans('titles.pending-users') }} ({{ $unapprovedUsers }})</option>
            </select>
        </div>
        <div class="col">
            <label for="state_of_select">{{ trans('titles.f-u-b-balance') }}</label>
            <select wire:model.defer="balanceUserSelected"  class="custom-select">
                <option selected value="null">All</option>
                <option value="1">{{ trans('titles.u-p-balance') }} ({{ $positiveBalanceUsersCount }})</option>
                <option value="2">{{ trans('titles.u-n-balance') }} ({{ $negativeBalanceUsersCount }})</option>
                <option value="3">{{ trans('titles.u-z-balance') }} ({{ $zeroBalanceUsersCount }})</option>
            </select>
        </div>
        <div class="col">
            <label for="state_of_select">{{ trans('titles.f-u-b-role') }}</label>
            <select wire:model.defer="roleUserSelected"  class="custom-select">
                <option selected value="null">All</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label for="state_of_select">{{ trans('titles.f-u-b-city') }}</label>
            <select wire:model.defer="cityUserSelected"  class="custom-select">
                <option selected value="null">{{ trans('titles.all') }}</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->legal_seat_city }}">{{ ucfirst($city->legal_seat_city) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <button class="btn btn-success" wire:click="commit">{{ trans('titles.commit') }}</button>
        </div>
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
                    <span>{{ trans('titles.balance') }} (€)</span>
                    @if($sortAsc && $sortField == 'plafond')
                        <i class="cil-arrow-bottom"></i>
                    @else
                        <i class="cil-arrow-top"></i>
                    @endif
                </th>
                <th wire:click="sortBy('credit')">
                    <span>{{ trans('titles.credit') }} (€)</span>
                    @if($sortAsc && $sortField == 'credit')
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
                            @if (!$user->trashed())
							<button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
								{{ $user->id }}
								<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
								<span class="sr-only">
									{{ trans('titles.actions') }}
								</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
								@if (!$user->state)
									<button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
										wire:click="approve({{ $user->id }})">{{ trans('titles.approve') }}</button>
								@endif
								<a href="{{ url('/users/' . $user->id) }}" class="dropdown-item btn-primary">{{ __('coreuiforms.view') }}</a>
								<a href="{{ url('/users/' . $user->id. '/edit') }}" class="dropdown-item btn-success">{{ __('coreuiforms.edit') }}</a>
								@if ($you->id !== $user->id)
									@if ($user->hasrole('user')||$user->hasrole('sales'))
									<a href="{{ url('/users/' . $user->id. '/impersonate') }}" class="dropdown-item btn-warning">{{ trans('titles.impersonate') }}</a>
									@endif
									<button class="dropdown-item btn-danger" data-toggle="modal" data-target="#modalDelete"
										wire:click="destroy({{ $user->id }})">{{ __('coreuiforms.delete') }}</button>
								@endif
                            </div>
                            @else
                                <span>{{ $user->id }}</span>
                            @endif
						</div>
                    </td>
                    <td>{{ ucfirst($user->company_data->company_name ?? '') }}</td>
                    <td>{{ ucfirst($user->company_data->legal_seat_city ?? '') }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(',', $user->getRoleNames()->toArray()) }}</td>
                    <td>{{ $user->plafond }}</td>
                    <td>{{ $user->credit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}

    <form action="{{ route('admin.user.export') }}" method="GET">
        @csrf
        <input type="hidden" name="stateUserSelected" value="{{ $stateUserSelected }}">
        <input type="hidden" name="balanceUserSelected" value="{{ $balanceUserSelected }}">
        <input type="hidden" name="roleUserSelected" value="{{ $roleUserSelected }}">
        <input type="hidden" name="cityUserSelected" value="{{ $cityUserSelected }}">
        <button class="btn btn-success">{{ trans('titles.export') }}</button>
    </form>
</div>
