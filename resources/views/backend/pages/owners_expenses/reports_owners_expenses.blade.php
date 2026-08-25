@extends('backend2.layouts_new.master')

@section('page_title')
    {{trans('back.reports_owners_expenses')}}
@endsection

@section('title')
    {{trans('back.reports_owners_expenses')}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            {{-- فورم البحث بين تاريخين --}}
            <form action="" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="" class="font-weight-bold">
                            {{trans('back.owner')}}
                        </label>
                        <select class="form-control select2" name="owner_id" required>
                            <option value="0">{{trans('back.All')}}</option>
                            @foreach(App\Models\Owner::all() as $owner)
                                <option value="{{ $owner->id }}" {{ old('owner_id', request()->input('owner_id')) == $owner->id ? 'selected' : null }}>
                                    {{ $owner->name ?? "" }} / {{ $owner->Owner->name ?? "" }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label >{{trans('back.start_date')}}</label>
                        <input name="start_date" class="form-control form-control-sm " type="date" value="{{ $start_date??"" }}">
                    </div>
                    <div class="col-md-2">
                        <label > {{trans('back.end_date')}}</label>
                        <input name="end_date" class="form-control form-control-sm " type="date" value="{{ $end_date??"" }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-sm" style="margin-top: 25px" type="submit" formaction="{{ route('reports_owners_expenses') }}"> {{trans('back.Search')}}  </button>
                        <button class="btn btn-secondary btn-sm" style="margin-top: 25px" type="submit" formaction="{{route('reports_owners_expenses_excel')}}"> Excel </button>
                        <a href="{{ route('reports_owners_expenses') }}" style="margin-top: 25px" class="btn btn-success btn-sm" type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="table-responsive">
                    <table  class="table text-center  table-bordered table-sm ">
                        <thead>
                        <tr style="background-color: rgb(232,245,252)">
                            <th>#</th>
                            <th> {{trans('back.owner')}}</th>
                            <th>{{trans('back.amount')}}</th>
                            <th> {{trans('back.expense_date')}}</th>
                            <th> {{trans('back.attached')}}</th>
                            <th> {{trans('back.Created_at')}}</th>
                            <th width="180">{{trans('back.Action')}}</th>
                            <th>{{trans('back.User')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($owners_expenses as $key => $owners_expense)
                            <tr>
                                <td>{{$key+ $owners_expenses->firstItem()}}</td>
                                <td>{{ $owners_expense->Owner->name ?? '' }}</td>
                                <td>{{ $owners_expense->amount }}</td>
                                <td>{{ $owners_expense->expense_date }}</td>
                                <td>
                                    @if($owners_expense->image)
                                        <a href="{{asset($owners_expense->image)}}" target="_blank" class="btn btn-secondary btn-xs"> {{trans('back.attached')}}</a>
                                    @else
                                        {{trans('back.none')}}
                                    @endif
                                </td>
                                <td>{{ $owners_expense->created_at }}</td>
                                <td>
                                    @can('edit_owners_expense')
                                        <a class="btn btn-success btn-xs " href="{{route('owners_expenses.edit', $owners_expense->id)}}" >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete_owners_expense')
                                        <a href="" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#delete_owners_expense{{$owners_expense->id}}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        @include('backend2.pages.owners_expenses.delete')
                                    @endcan
                                </td>
                                <td>{{ $owners_expense->User->name ?? "" }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{number_format($total_amount, 3)}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                {!! $owners_expenses->appends(Request::all())->links() !!}

            </div>
        </div>
    </div>

@endsection

