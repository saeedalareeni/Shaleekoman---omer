@extends('backend.layouts.master')

@section('page_title')
{{trans('back.users')}}
@endsection

@section('title')
{{trans('back.users')}}
@endsection

@section('content')

    <style>
        .btn-action {
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .btn-add-new {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            font-weight: 500;
        }
        
        .btn-add-new:hover {
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>

    <div class="row">
        @can('create_user')
            <div class="col-md-12 mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-add-new btn-action">
                    <i class="fas fa-plus-circle"></i>
                    {{trans('back.Add_New_User')}}
                </a>
            </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-box">

                    <div class="table-responsive">
                        <table xs class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('back.name')}}</th>
                                <th>{{trans('back.Email')}} </th>
                                <th>{{trans('back.Permissions')}} </th>
                                <th> {{trans('back.actions')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($data as $key => $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td> {{ $user->name }}</td>
                                    <td> {{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge bg-secondary">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>

                                        @if($user->id == 1 || $user->id == 2)
                                            @can('show_user')
                                                <a class="btn btn-info btn-sm btn-action disabled" href="{{ route('users.show',$user->id) }}">
                                                    <i class="fas fa-eye"></i> {{trans('back.Show')}}
                                                </a>
                                            @endcan

                                            @can('edit_user')
                                                <a class="btn btn-success btn-sm btn-action disabled"  href="{{ route('users.edit',$user->id) }}">
                                                    <i class="fas fa-edit"></i> {{trans('back.edit')}}
                                                </a>
                                            @endcan

                                            @can('delete_user')
                                                <button type="button" class="btn btn-danger btn-sm btn-action" disabled data-bs-toggle="modal" data-bs-target="#delete_user{{ $user->id }}">
                                                    <i class="fas fa-trash"></i> {{trans('back.delete')}}
                                                </button>
                                            @endcan
                                        @else
                                            @can('show_user')
                                                <a class="btn btn-info btn-sm btn-action" href="{{ route('users.show',$user->id) }}">
                                                    <i class="fas fa-eye"></i> {{trans('back.Show')}}
                                                </a>
                                            @endcan

                                            @can('edit_user')
                                                <a class="btn btn-success btn-sm btn-action" href="{{ route('users.edit',$user->id) }}">
                                                    <i class="fas fa-edit"></i> {{trans('back.edit')}}
                                                </a>
                                            @endcan

                                            @can('delete_user')
                                                <button type="button" class="btn btn-danger btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#delete_user{{ $user->id }}">
                                                    <i class="fas fa-trash"></i> {{trans('back.delete')}}
                                                </button>
                                            @endcan

                                        @endif
                                        @include('backend.pages.users.delete')

                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12">
                            {!! $data->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
