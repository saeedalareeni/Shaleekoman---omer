<!-- Modal -->
<div class="modal fade" id="add_Owner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.add_new_owner')}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('owners.store') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name"> {{trans('back.name')}} *</label>
                            <input type="text" class="form-control"  name="name" placeholder="{{trans('back.name')}} " value="{{ old('name') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">{{trans('back.phone')}} *</label>
                            <input type="number" class="form-control"  name="phone" placeholder="{{trans('back.phone')}}" value="{{ old('phone') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">{{trans('back.Email')}}  </label>
                            <input type="email" class="form-control"  name="email" placeholder="{{trans('back.Email')}} " value="{{ old('email') }}">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{trans('back.password')}}</label>
                                <input type="password" class="form-control"  name="password" placeholder="{{trans('back.password')}} ">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">{{ trans('back.image') }}</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address"> {{trans('back.address')}}   </label>
                            <input type="text" class="form-control"  name="address" placeholder="{{trans('back.address')}}  " value="{{ old('address') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bank_account_name"> {{trans('back.bank_account_name')}}   </label>
                            <input type="text" class="form-control"  name="bank_account_name" placeholder="{{trans('back.bank_account_name')}}  " value="{{ old('bank_account_name') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bank_account_number"> {{trans('back.bank_account_number')}}   </label>
                            <input type="text" class="form-control"  name="bank_account_number" placeholder="{{trans('back.bank_account_number')}}  " value="{{ old('bank_account_number') }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="commission">{{trans('back.commission')}} </label>
                            <input type="number" class="form-control"  name="commission" placeholder="{{trans('back.commission')}}" value="{{ old('commission') }}">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{trans('back.close')}}  </button>
                        <button type="submit" class="btn btn-primary"> {{trans('back.add')}}  </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

