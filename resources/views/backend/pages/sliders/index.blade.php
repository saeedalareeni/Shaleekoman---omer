@extends('backend.layouts.master')

@section('title')
{{trans('back.sliders')}}
@endsection

@section('title')
{{trans('back.sliders')}}
@endsection


@section('content')


    <div class="col-md-12">
        {{-- @can('add_slider') --}}
            <button type="button" class="btn btn-secondary btn-sm mb-2" data-toggle="modal" data-target="#add_Slider">
                <i class="fas fa-plus"></i>
                {{trans('back.add_slider')}}
            </button>
        {{-- @endcan --}}
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="" class="table table-bordered text-center table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('back.image')}}</th>
                                <th>{{trans('back.title_ar')}}</th>
                                <th>{{trans('back.title_en')}}</th>
                                <th>{{trans('back.url')}}</th>
                                <th>{{trans('back.Status')}}</th>
                                <th>{{trans('back.actions')}}</th>
                                <th>{{trans('back.Created_at')}}</th>
                            </tr>
                            </thead>
                            @php $i=1 @endphp

                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td> <a href="{{asset($slider->image)}}"> <img src="{{asset($slider->image)}}" alt="{{$slider->title_ar}}" width="60px"> </a> </td>
                                    <td> {{$slider->title_ar}}</td>
                                    <td> {{$slider->title_en}}</td>
                                    <td> {{$slider->url}}</td>
                                    <td>{{$slider->status()}}</td>
                                    <td>
                                        {{-- @can('edit_slider') --}}
                                        <a href="" class="btn btn-success btn-xs ml-1" data-toggle="modal" data-target="#edit_Slider{{$slider->id}}">
                                            {{trans('back.edit')}}
                                        </a>
                                        {{-- @endcan --}}
                                        {{-- @can('delete_slider') --}}
                                        <a href="" class="btn btn-danger btn-xs ml-1" data-toggle="modal" data-target="#delete_Slider{{$slider->id}}">
                                            {{trans('back.Delete')}}
                                        </a>
                                        {{-- @endcan --}}
                                    </td>
                                    <td>{{$slider->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->

    {{-- Add Modal --}}
    @include('backend.pages.sliders.add')

    {{-- Edit and Delete Modals --}}
    @foreach($sliders as $slider)
        @include('backend.pages.sliders.edit')
        @include('backend.pages.sliders.delete')
    @endforeach

@endsection

@push('styles')
<style>
    /* Fix for modal backdrop issue */
    .modal-backdrop {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 1040 !important;
        width: 100vw !important;
        height: 100vh !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    
    .modal {
        position: fixed !important;
        z-index: 1050 !important;
        display: none;
        overflow: hidden;
        outline: 0;
    }
    
    .modal.show {
        display: block !important;
    }
    
    .modal-dialog {
        position: relative !important;
        z-index: 1060 !important;
        margin: 1.75rem auto !important;
        pointer-events: auto !important;
    }
    
    /* Remove multiple backdrops */
    .modal-backdrop + .modal-backdrop {
        display: none !important;
    }
    
    /* Ensure modal content is visible */
    .modal-content {
        position: relative !important;
        background-color: #fff !important;
        z-index: 1070 !important;
    }
    
    /* Fix for body when modal is open */
    body.modal-open {
        overflow: hidden !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Remove any existing backdrops on page load
        $('.modal-backdrop').remove();
        
        // Fix for modal backdrop issue
        $('.modal').on('show.bs.modal', function (e) {
            // Remove any existing backdrops first
            $('.modal-backdrop').remove();
            
            // Ensure the modal has proper z-index
            $(this).css('z-index', 1050);
            
            // Create backdrop manually if needed
            setTimeout(function() {
                if ($('.modal-backdrop').length === 0) {
                    $('<div class="modal-backdrop fade show"></div>').appendTo(document.body);
                }
                // Ensure backdrop is behind modal
                $('.modal-backdrop').css('z-index', 1040);
            }, 10);
        });
        
        $('.modal').on('hidden.bs.modal', function (e) {
            // Clean up on modal close
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        });
        
        // Handle modal button clicks
        $('[data-toggle="modal"]').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('data-target');
            
            // Close any open modals first
            $('.modal').modal('hide');
            
            // Small delay then open the new modal
            setTimeout(function() {
                $(target).modal('show');
            }, 300);
        });
    });
</script>
@endpush
