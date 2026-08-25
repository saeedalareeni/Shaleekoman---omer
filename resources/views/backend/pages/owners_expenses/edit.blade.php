<!-- Modal -->
<div class="modal fade" id="edit_owners_expense{{ $owners_expense->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('back.edit_owners_expense')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action=" {{ route('owners_expenses.update', $owners_expense->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="amount">{{trans('back.amount')}} </label>
                            <b class="text-danger">*</b>
                            <input type="hidden" name="owner_id" value="{{ $owner->id }}">
                            <input type="number" class="form-control expense_amount_edit" step="any" placeholder="{{trans('back.amount')}}" name="amount" value="{{$owners_expense->amount}}" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="expense_date"> {{trans('back.expense_date')}} </label>
                            <b class="text-danger">*</b>
                            <input type="date" class="form-control" placeholder=" {{trans('back.expense_date')}}" name="expense_date" value="{{$owners_expense->expense_date}}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="payment_method_id" >{{trans('back.select_payment_methods')}}:</label>
                            <b class="text-danger">*</b>
                            <select class="form-control " name="payment_method_id" required>
                                <option value="">{{trans('back.select_payment_methods')}}</option>
                                @foreach(App\Models\Payment_method::all() as $payment_method)
                                    <option value="{{ $payment_method->id }}" {{ old('payment_method_id', $owners_expense->payment_method_id) == $payment_method->id ? 'selected' : null }}>
                                        @if(app()->getLocale() == 'ar')
                                            {{ $payment_method->name_ar }}
                                        @else
                                            {{ $payment_method->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3" >
                            <label for="check_number">{{trans('back.Check_number_if_any')}}:</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.Check_number')}}" name="check_number" value="{{$owners_expense->check_number}}" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="image">{{trans('back.attached')}}</label>
                            <input type="file" class="form-control"  name="image" >
                        </div>

                        <div class="form-group col-md-4">
                            <label for="image">{{trans('back.attached')}}</label>
                            <br>
                            @if($owners_expense->image)
                                <a href="{{asset($owners_expense->image)}}" target="_blank" class="btn btn-secondary btn-xs"> {{trans('back.show')}}</a>
                            @else
                                {{trans('back.none')}}
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <label for="about">{{trans('back.about')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.about')}}" name="about" value="{{$owners_expense->about}}">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">  {{trans('back.notes')}} </label>
                            <textarea class="form-control" name="notes" rows="4"> {{ $owners_expense->notes }}</textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.close')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('back.Add')}}</button>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
