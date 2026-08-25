<!-- Modal -->
<div class="modal fade" id="edit_customer{{$customer->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.Edit_Customer')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-left">

                <form action=" {{ route('customers.update', $customer->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{trans('back.Customer_Name')}} </label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control"   name="name" placeholder="{{trans('back.Customer_Name')}}" value="{{ $customer->name }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">{{trans('back.email')}} </label>
                            <b class="text-danger">*</b>
                            <input type="email" class="form-control"   name="email" placeholder="{{trans('back.email')}}" value="{{ $customer->email }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">{{trans('back.phone')}} </label>
                            <b class="text-danger">*</b>
                            <input type="number" class="form-control"   name="phone" placeholder="{{trans('back.phone')}}" value="{{ $customer->phone }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">{{trans('back.password')}} </label>
                            <b class="text-danger">*</b>
                            <input type="password" class="form-control"   name="password" placeholder="{{trans('back.password')}}" value="{{ old('password') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Save')}}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
