@extends('backend.layouts.master_employee')

@section('pageTitle')
    {{trans('back.send_message_to_management')}}
@endsection

@section('page_title')
    {{trans('back.send_message_to_management')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <form action="{{route('Messages.store')}}" method="post">
                    @csrf
                    <div class="form-row">

                        <input type="hidden" class="form-control" name="employee_id" value=" {{auth()->user()->id}}">

                        <div class="form-group col-md-12">
                            <label for="title">{{trans('back.Message_title')}}</label>
                            <input type="text" class="form-control" placeholder="{{trans('back.Message_title')}} "
                                   name="title" value="{{old('title')}}" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="notes">{{trans('back.Message_text')}}</label>
                            <textarea class="form-control" name="notes" rows="8">{{old('notes')}}</textarea>
                        </div>

                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success"> {{trans('back.Save_and_send')}} </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
