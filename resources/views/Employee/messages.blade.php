@extends('backend.layouts.master_employee')

@section('pageTitle')
    {{trans('back.messages')}}
@endsection

@section('page_title')
    {{trans('back.messages')}}
@endsection


@section('content')

    <div class="row">
        <div class="col-md-9 mb-1">
            <a class="btn btn-purple btn-sm" href="{{route('Messages.create')}}">
                <i class="mdi mdi-plus"></i>
                {{trans('back.send_message_to_management')}}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">


                <div class="table-responsive">
                    <table class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr>
                            <th width="25">#</th>
                            <th width="100">{{trans('back.Message_title')}}</th>
                            <th width="300">{{trans('back.message')}}</th>
                            <th width="100">{{trans('back.Date_Message')}}</th>
                            <th width="300">{{trans('back.reply')}}</th>
                            <th width="100">{{trans('back.updated_at')}}</th>
                            <th width="100">{{trans('back.Status')}} </th>
                            <th width="100"> {{trans('back.Actions')}}</th>
                        </tr>
                        </thead>

                        @php $i=1 @endphp
                        <tbody>
                        @foreach($messages as $message)
                            <tr @if($message->status == 0) style="background-color: #fcd8d8" @else style="background-color: #d0ffd2" @endif>
                                <td>{{$i++}}</td>
                                <td> {{ $message->title }}</td>
                                <td>{{ $message->notes }}</td>
                                <td>{{ $message->created_at }}</td>
                                <td>{{ $message->reply }}</td>
                                <td>{{ $message->updated_at }}</td>
                                <td> {{$message->status()}}</td>
                                <td>
                                    @if($message->reply)
                                        <a class="btn btn-success btn-xs ml-1 disabled" href="{{ route('Messages.edit',$message->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-xs ml-1 disabled" data-toggle="modal"  data-target="#delete_message{{$message->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-success btn-xs ml-1 " href="{{ route('Messages.edit',$message->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-xs ml-1 " data-toggle="modal"  data-target="#delete_message{{$message->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('Employee.delete_message')
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
