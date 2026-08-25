<div class="row ">
    <div class="col-md-8 card">
        <form action="{{ route('profile-update') }}" method="post" class="text-left card-body">
            @csrf
            <div class="row">

                <input type="hidden" name="id" value="{{auth('customer')->user()->id}}">
                <div class="form-group col-md-12 mb-2">
                    <label class="form-label" for="name"> {{trans('back.name')}}  </label>
                    <input type="text" class="form-control"  name="name"  value="{{ auth('customer')->user()->name }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 mb-2">
                    <label class="form-label" for="phone">{{trans('back.phone')}} </label>
                    <input type="number" class="form-control"  name="phone"  value="{{ auth('customer')->user()->phone }}">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 mb-2">
                    <label class="form-label" for="email">{{trans('back.Email')}}  </label>
                    <input type="email" class="form-control"  name="email"  value="{{ auth('customer')->user()->email }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-12 mb-2">
                    <label class="form-label" for="address"> {{trans('back.address')}}   </label>
                    <input type="text" class="form-control"  name="address" value="{{ auth('customer')->user()->address }}">
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6 mb-2">
                    <button type="submit" class="btn btn-primary"> {{trans('back.Save_and_Update')}}  </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-4 card">
        <div class="card-body">
            <h5 class="mb-3 font-weight-semibold"> {{trans('back.reset_password')}}</h5>
            <form method="POST" action="{{ route('reset-password') }}" class="">
                @csrf
                <input class="form-control" name="id" type="hidden" value="{{ auth('customer')->user()->id}}">
                <div class="form-group mb-2">
                    <label class="form-label">  {{trans('back.Enter_new_password')}} </label>
                    <input class="form-control" name="password"  placeholder="********"   type="password">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-2">
                    <label class="form-label"> {{trans('back.confirm_password')}} </label>
                    <input class="form-control" name="confirm-password"  placeholder="" type="password">
                    @error('confirm-password')   <div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="mb-2 btn btn-primary w-100"> {{ trans('back.Confirm') }}  </button>

            </form>
        </div>
    </div>
</div>
