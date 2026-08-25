@extends('backend.layouts.master')
@section('page_title')
{{ trans('back.customer_messages') }}
@endsection
@section('title')
{{ trans('back.customer_messages') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 mb-1">
            @can('search_customer_message')
                <form action="{{ route('customer-messages.index') }}" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="query" value="{{old('query', request()->input('query'))}}" placeholder="{{ __('back.search') }}.." id="query" >
                        <button class="btn btn-purple btn-sm ml-1" type="submit" title="Search">
                            <span class="fas fa-search"></span>
                        </button>
                        <a href="{{ route('customer-messages.index') }}" class="btn btn-success btn-sm ml-1 " type="button" title="Reload">
                            <span class="fas fa-sync-alt"></span>
                        </a>
                    </div>
                </form>
            @endcan
        </div>
    </div>


    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('customer-messages.bulk-destroy') }}" method="POST" id="bulkDeleteForm" class="d-none">
                        @csrf
                    </form>
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2" style="gap: 10px;">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectAllMessages">
                                    <label class="custom-control-label" for="selectAllMessages">{{ app()->getLocale() == 'ar' ? 'تحديد الكل' : 'Select all' }}</label>
                                </div>
                            </div>
                            <button type="submit" form="bulkDeleteForm" class="btn btn-danger btn-sm" id="bulkDeleteBtn" disabled>
                                {{ app()->getLocale() == 'ar' ? 'حذف المحدد' : 'Delete selected' }}
                            </button>
                        </div>
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th style="width: 40px;">✓</th>
                                <th>#</th>
                                <th>{{trans('back.name')}}</th>
                                <th>{{trans('back.phone')}}</th>
                                <th>{{trans('back.email')}}</th>
                                <th>{{trans('back.message')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                                <th>{{trans('back.actions')}}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($customer_messages as $key => $customer_message)
                                <tr>
                                    <td>
                                        <input type="checkbox" form="bulkDeleteForm" name="ids[]" value="{{ $customer_message->id }}" class="message-checkbox">
                                    </td>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$customer_message->name}}</td>
                                    <td>{{$customer_message->phone}}</td>
                                    <td>{{$customer_message->email}}</td>
                                    <td>{{$customer_message->message}}</td>
                                    <td>{{$customer_message->created_at}}</td>
                                    <td>
                                        @can('delete_customer_message')
                                            <a href="" class="btn btn-danger btn-xs ml-1 " data-toggle="modal" data-target="#delete_customer_message{{$customer_message->id}}">
                                                {{trans('back.Delete')}}
                                            </a>
                                        @endcan
                                        @include('backend.pages.customer_messages.delete')
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {!! $customer_messages->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

@endsection


@section('js')

    <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            language: 'ar',
            height: 500
        });
    </script>

    <script>
        (function() {
            const selectAll = document.getElementById('selectAllMessages');
            const bulkBtn = document.getElementById('bulkDeleteBtn');
            const checkboxes = () => Array.from(document.querySelectorAll('.message-checkbox'));

            function updateBulkState() {
                const boxes = checkboxes();
                const checkedCount = boxes.filter(cb => cb.checked).length;
                if (bulkBtn) bulkBtn.disabled = checkedCount === 0;
                if (selectAll) selectAll.checked = boxes.length > 0 && checkedCount === boxes.length;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes().forEach(cb => cb.checked = selectAll.checked);
                    updateBulkState();
                });
            }

            document.addEventListener('change', function(e) {
                if (e.target && e.target.classList && e.target.classList.contains('message-checkbox')) {
                    updateBulkState();
                }
            });

            const form = document.getElementById('bulkDeleteForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const anyChecked = checkboxes().some(cb => cb.checked);
                    if (!anyChecked) {
                        e.preventDefault();
                        return false;
                    }
                    if (!confirm('{{ app()->getLocale() == "ar" ? "هل أنت متأكد من حذف الرسائل المحددة؟" : "Are you sure you want to delete selected messages?" }}')) {
                        e.preventDefault();
                        return false;
                    }
                });
            }

            updateBulkState();
        })();
    </script>

@endsection
