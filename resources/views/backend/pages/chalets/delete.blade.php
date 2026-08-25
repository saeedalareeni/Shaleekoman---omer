    <!-- Delete Modal -->
    <div class="modal fade" id="delete_chalet{{ $chalet->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteChaletModalLabel{{ $chalet->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteChaletModalLabel{{ $chalet->id }}">{{ trans('back.delete') }} Chalet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('back.are_you_sure') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('back.cancel') }}</button>
                    <form action="{{ route('chalets.destroy', $chalet->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ trans('back.delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
