<div>
    @include('livewire.user.approve')
    @include('livewire.user.destroy')
    <div class="btn-group btn-group-xs mb-1">
        @if (!$user->trashed())
            <button type="button" class="btn btn-table-action dropdown-toggle" data-toggle="dropdown">
                {{ $user->id }}
                <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                <span class="sr-only">Actions</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (!$user->state)
                    <button class="dropdown-item btn-success" data-toggle="modal" data-target="#modalApprove"
                            wire:click="approve({{ $user->id }})">Approve</button>
                @endif
                <a href="{{ url('/users/' . $user->id) }}" class="dropdown-item btn-primary">{{ __('coreuiforms.view') }}</a>
                <a href="{{ url('/users/' . $user->id. '/edit') }}" class="dropdown-item btn-success">{{ __('coreuiforms.edit') }}</a>
                @if (auth()->id() !== $user->id)
                    @if ($user->hasrole('user')||$user->hasrole('sales'))
                        <a href="{{ url('/users/' . $user->id. '/impersonate') }}" class="dropdown-item btn-warning">Impersonate</a>
                    @endif
                    <button class="dropdown-item btn-danger" data-toggle="modal" data-target="#modalDelete"
                            wire:click="destroy({{ $user->id }})">{{ __('coreuiforms.delete') }}</button>
                @endif
            </div>
        @else
            <span>{{ $user->id }}</span>
        @endif
        <div class="ml-2"> {{ $user->name }} </div>
    </div>
</div>
