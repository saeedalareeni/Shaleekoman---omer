<!-- Modal -->
<div class="modal fade" id="model_status{{$chalet->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.status')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('chalets.status')}}" method="post">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $chalet->slug }}">
                    <div class="form-group col-md-12">
                        <label for="status">{{ trans('back.status') }}</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ old('status',$chalet->status) == 'pending' ? 'selected' : '' }}>{{ trans('back.pending') }}</option>
                            <option value="approved" {{ old('status',$chalet->status) == 'approved' ? 'selected' : '' }}>{{ trans('back.approved') }}</option>
                            <option value="rejected" {{ old('status',$chalet->status) == 'rejected' ? 'selected' : '' }}>{{ trans('back.rejected') }}</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="text" name="note" id=""  class="form-control">
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-success">{{trans('back.save')}}</button>
                        <button type="button" class="btn btn-purple" data-dismiss="modal"> {{trans('back.close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
