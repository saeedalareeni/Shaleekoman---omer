<!-- Modal -->
<div class="modal fade" id="add_coupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('back.add_coupon') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">

                <form action="{{ route('coupons.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="code">{{ trans('back.code') }}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" name="code" placeholder="{{ trans('back.code') }}" value="{{ old('code') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount_percentage">{{ trans('back.discount_percentage') }}</label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control" name="discount_percentage" placeholder="{{ trans('back.discount_percentage') }}" value="{{ old('discount_percentage') }}" min="1" max="100" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="max_uses">{{ trans('back.max_uses') }}</label>
                            <input type="number" class="form-control" name="max_uses" placeholder="{{ trans('back.max_uses') }}" value="{{ old('max_uses', 1) }}" min="1">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expires_at">{{ trans('back.expires_at') }}</label>
                            <input type="date" class="form-control" name="expires_at" value="{{ old('expires_at') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="is_active">{{ trans('back.status') }}</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>{{ trans('back.active') }}</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>{{ trans('back.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('back.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('back.Add') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
