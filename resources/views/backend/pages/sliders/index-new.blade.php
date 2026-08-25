@php
    use Illuminate\Support\Str;
@endphp

@extends('backend.layouts.master')

@section('title')
{{trans('back.sliders')}}
@endsection

@section('content')

    <div class="col-md-12">
        {{-- @can('add_slider') --}}
            <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="openAddModal()">
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
                                    <td> 
                                        @if($slider->image)
                                            <a href="{{$slider->image_url}}" target="_blank"> 
                                                <img src="{{$slider->image_url}}" alt="{{$slider->title_ar}}" width="60px" style="object-fit: cover; height: 40px; border-radius: 4px;"> 
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td> {{$slider->title_ar}}</td>
                                    <td> {{$slider->title_en}}</td>
                                    <td> {{$slider->url}}</td>
                                    <td>{{$slider->status()}}</td>
                                    <td>
                                        {{-- @can('edit_slider') --}}
                                        <button class="btn btn-success btn-xs ml-1" onclick='openEditModal(@json($slider))'>
                                            {{trans('back.edit')}}
                                        </button>
                                        {{-- @endcan --}}
                                        {{-- @can('delete_slider') --}}
                                        <button class="btn btn-danger btn-xs ml-1" onclick='openDeleteModal({{$slider->id}}, "{{$slider->title_ar}}")'>
                                            {{trans('back.Delete')}}
                                        </button>
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

    <!-- Single Dynamic Modal -->
    <div class="modal fade" id="sliderModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" onclick="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Override Bootstrap modal backdrop */
    .modal-backdrop {
        display: none !important;
    }
    
    /* Custom backdrop */
    .custom-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1040;
    }
    
    /* Ensure modal is on top */
    #sliderModal {
        z-index: 1050 !important;
    }
    
    #sliderModal .modal-dialog {
        z-index: 1060 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function closeModal() {
        $('#sliderModal').modal('hide');
        $('.modal-backdrop').remove();
        $('.custom-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
    }

    function openAddModal() {
        // Remove any existing backdrops first
        $('.modal-backdrop').remove();
        $('.custom-backdrop').remove();
        
        $('#modalTitle').text('{{trans("back.add_slider")}}');
        $('#modalBody').html(`
            <form action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.title_ar')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.title_ar')}}" name="title_ar" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.title_en')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.title_en')}}" name="title_en" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.url')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.url')}}" name="url" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.Status')}}</label>
                        <select name="status" class="form-control">
                            <option value="1">{{trans('back.Active')}}</option>
                            <option value="0">{{trans('back.Inactive')}}</option>
                        </select>
                    </div>
                    <div class="mb-2 col-md-12">
                        <label class="form-label">{{trans('back.image')}}</label>
                        <input type="file" class="form-control form-control-file" name="image" id="addImageInput" onchange="previewAddImage(event)" required>
                        <div id="addImagePreview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">{{trans('back.close')}}</button>
                    <button type="submit" class="btn btn-success">{{trans('back.Save')}}</button>
                </div>
            </form>
        `);
        
        // Show modal with custom backdrop
        $('body').append('<div class="custom-backdrop"></div>');
        $('#sliderModal').modal({
            backdrop: false,
            keyboard: true
        });
    }

    function openEditModal(slider) {
        // Remove any existing backdrops first
        $('.modal-backdrop').remove();
        $('.custom-backdrop').remove();
        $('#modalTitle').text('{{trans("back.edit_slider")}}');
        $('#modalBody').html(`
            <form action="/sliders/${slider.id}" method="post" enctype="multipart/form-data" class="text-left">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.title_ar')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.title_ar')}}" name="title_ar" value="${slider.title_ar}" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.title_en')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.title_en')}}" name="title_en" value="${slider.title_en}" required>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.url')}}</label>
                        <input type="text" class="form-control" placeholder="{{trans('back.url')}}" name="url" value="${slider.url}" required>
                    </div>
                    <div class="mb-2 col-6">
                        <label class="form-label">{{trans('back.Status')}}</label>
                        <select name="status" class="form-control">
                            <option value="1" ${slider.status == 1 ? 'selected' : ''}>{{trans('back.Active')}}</option>
                            <option value="0" ${slider.status == 0 ? 'selected' : ''}>{{trans('back.Inactive')}}</option>
                        </select>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.image')}} (جديدة)</label>
                        <input type="file" class="form-control form-control-file" name="image" id="editImageInput" onchange="previewEditImage(event)">
                        <div id="newImagePreview" class="mt-2"></div>
                    </div>
                    <div class="mb-2 col-md-6">
                        <label class="form-label">{{trans('back.image')}} (الحالية)</label> <br>
                        <div style="border: 1px solid #dee2e6; padding: 10px; border-radius: 5px; background: #f8f9fa;">
                            ${slider.image ? 
                                `<img src="${slider.image.startsWith('http') ? slider.image : '{{asset('/')}}' + slider.image}" alt="${slider.title_ar}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                 <br><small class="text-muted">${slider.image}</small>` : 
                                '<span class="text-muted">لا توجد صورة حالية</span>'}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">{{trans('back.close')}}</button>
                    <button type="submit" class="btn btn-success">{{trans('back.save_and_update')}}</button>
                </div>
            </form>
        `);
        
        // Show modal with custom backdrop
        $('body').append('<div class="custom-backdrop"></div>');
        $('#sliderModal').modal({
            backdrop: false,
            keyboard: true
        });
    }

    function openDeleteModal(id, title) {
        // Remove any existing backdrops first
        $('.modal-backdrop').remove();
        $('.custom-backdrop').remove();
        $('#modalTitle').text('{{trans("back.delete_slider")}}');
        $('#modalBody').html(`
            <form action="/sliders/${id}" method="post">
                @csrf
                @method('DELETE')
                <div class="text-center">
                    <h4>{{trans('back.Are_you_sure_to_delete')}}</h4>
                    <p>${title}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">{{trans('back.close')}}</button>
                    <button type="submit" class="btn btn-danger">{{trans('back.Delete')}}</button>
                </div>
            </form>
        `);
        
        // Show modal with custom backdrop
        $('body').append('<div class="custom-backdrop"></div>');
        $('#sliderModal').modal({
            backdrop: false,
            keyboard: true
        });
    }

    // Preview functions for images
    function previewAddImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#addImagePreview').html(`
                    <div style="border: 1px solid #28a745; padding: 10px; border-radius: 5px; background: #d4edda;">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                        <br><small class="text-success">معاينة الصورة الجديدة</small>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        }
    }
    
    function previewEditImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#newImagePreview').html(`
                    <div style="border: 1px solid #28a745; padding: 10px; border-radius: 5px; background: #d4edda;">
                        <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                        <br><small class="text-success">معاينة الصورة الجديدة</small>
                    </div>
                `);
            }
            reader.readAsDataURL(file);
        }
    }

    // Clean up on page load
    $(document).ready(function() {
        $('.modal-backdrop').remove();
        $('.custom-backdrop').remove();
        $('body').removeClass('modal-open');
        
        // Handle ESC key
        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                closeModal();
            }
        });
        
        // Close modal when clicking on custom backdrop
        $(document).on('click', '.custom-backdrop', function() {
            closeModal();
        });
    });
</script>
@endpush
