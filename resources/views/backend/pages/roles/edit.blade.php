@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.Edit_Role')}}
@endsection
@section('title')
    {{trans('back.Edit_Role')}}
@endsection

@section('content')

    <div class="row">
        @can('roles')
            <div class="col-md-12 mb-1">
                <a class="btn btn-purple btn-sm mb-1" href="{{ route('roles.index') }}">
                    <i class="fas fa-chevron-circle-right"></i>  {{trans('back.Back_All_Roles')}}
                </a>
            </div>
        @endcan
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-box">

                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{trans('back.name')}}:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name', $role->name) }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>{{trans('back.Search')}}:</label>
                                <input type="search" id="search_roles" class="form-control" placeholder="{{trans('back.Search')}}">
                            </div>
                            <div class="col-md-3" style="margin-top: 21px">
                                <button type="submit" class="btn btn-purple"> {{trans('back.Add')}}</button>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="mb-2">
                                        <input type="checkbox" id="checkAll">
                                        <label for="checkAll">{{trans('back.All')}} : </label>
                                    </div>

                                    <div class="row">
                                        @foreach($permission as $value)
                                            <div class="col-md-3" id="service">
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                    {{ trans('back.'.$value->name) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary"> {{trans('back.Save_and_Update')}} </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.getElementById("checkAll").addEventListener("click", function() {
            document.querySelectorAll("input[type='checkbox']").forEach(checkbox => {
                if (checkbox !== this) {
                    checkbox.checked = this.checked;
                }
            });
        });
    </script>

    <script>
        document.getElementById("search_roles").addEventListener("keyup", function() {
            let value = this.value.toLowerCase();
            document.querySelectorAll("#service label").forEach(label => {
                label.style.display = label.textContent.toLowerCase().includes(value) ? "block" : "none";
            });
        });
    </script>
@endsection
