<div wire:ignore.self class="modal fade" id="modalApprove" tabindex="-1" role="dialog" aria-labelledby="modalApproveTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApproveTitle">Approval of user: {{ $user_id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group has-feedback row">
                            <label for="parent_percent" class="col-md-3 control-label">Percentuale referente</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input wire:model.defer="parent_percent" id="parent_percent" class="form-control" placeholder="Percentuale referente"
                                        min="0" step="0.01" name="parent_percent" type="number">
                                    <div class="input-group-append">
                                        <label for="parent_percent" class="input-group-text">
                                            %
                                        </label>
                                    </div>
                                </div>
                                <div class="text-sm text-danger italic block">
                                    @error('parent_percent') {{$message}} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback row ">
                            <label for="group" class="col-md-3 control-label">Ruolo utente</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select wire:model.defer="group_id" class="form-control" id="group" name="group_id">
                                        <option value="" selected>Choose a group</option>
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
                                <div class="text-sm text-danger italic block">
                                    @error('group') {{$message}} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback row ">
                            <label for="group" class="col-md-3 control-label">Plafond</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input wire:model.defer="plafond" class="form-control" id="plafond" name="plafond" />
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="group">
                                            <i class="fa fa-fw fa-shield" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-sm text-danger italic block">
                                    @error('plafond') {{$message}} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback row ">
                            <label for="debt_limit" class="col-md-3 control-label">Plafond limit</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input wire:model.defer="debt_limit" class="form-control" id="debt_limit" name="debt_limit" />
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="group">
                                            <i class="fa fa-fw fa-shield" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-sm text-danger italic block">
                                    @error('debt_limit') {{$message}} @enderror
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" wire:click.prevent="store()">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
