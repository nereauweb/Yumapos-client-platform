<div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteTitle">{{ trans('titles.confirm-delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    {{ trans('descriptions.warning-delete-user') }}: {{ $this->user_id }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('titles.cancel') }}</button>
                    <button type="submit" class="btn btn-danger" wire:click="delete()">{{ trans('titles.delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
