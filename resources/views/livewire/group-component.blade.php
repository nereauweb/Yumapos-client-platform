<div>
    <div class="form-group has-feedback row {{ $errors->has('role') ? ' has-error ' : '' }}">
        {!! Form::label('role', trans('forms.create_user_label_role'), array('class' => 'col-md-3 control-label')); !!}
        <div class="col-md-9">
            <div class="input-group">
                <select wire:model="roleSelected" class="custom-select form-control" name="role" id="role" required>
                    <option value="">{{ trans('forms.create_user_ph_role') }}</option>
                    @if ($roles)
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    @endif
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="role">
                        <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                    </label>
                </div>
            </div>
            @if ($errors->has('role'))
                <span class="help-block">
                    <strong>{{ $errors->first('role') }}</strong>
                </span>
            @endif
        </div>
    </div>
    @if($roleSelected && !is_null($groups))
        <div class="form-group has-feedback row">
            <label for="group" class="col-md-3 control-label">Choose a group for {{ $roleSelected == 4 ? 'Agent' : 'User' }}</label>
            <div class="col-md-9">
                <div class="input-group">
                    <select name="group_id" id="group" class="custom-select form-control">
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <label class="input-group-text" for="role">
                            <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="form-group has-feedback row">
        <label for="group" class="col-md-3 control-label">Choose a group for User</label>
        <div class="col-md-9">
            <div class="input-group">
                <select name="default_group_id" id="default_group" class="custom-select form-control">
                    @foreach($defaultGroup as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <label class="input-group-text" for="role">
                        <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
