@extends('backend.layouts.master')

@section('page_title')
    {{trans('back.add_new_page')}}
@endsection

@section('title')
    {{trans('back.add_new_page')}}
@endsection

@section('css')
    <link href="{{ asset('backend/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .page-editor-shell {
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .page-editor-shell .ql-toolbar.ql-snow {
            border: 0;
            border-bottom: 1px solid #e9ecef;
        }

        .page-editor-shell .ql-container.ql-snow {
            border: 0;
            min-height: 360px;
            font-size: 15px;
        }

        .page-editor-shell.editor-en .ql-editor {
            direction: ltr;
            text-align: left;
        }

        .page-editor-shell.editor-ar .ql-editor {
            direction: rtl;
            text-align: right;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <form action="{{route('pages.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name_ar">{{trans('back.name_ar')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.name_ar')}}" name="name_ar" value="{{old('name_ar')}}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name_en">{{trans('back.name_en')}}</label>
                            <b class="text-danger">*</b>
                            <input type="text" class="form-control" placeholder="{{trans('back.name_en')}}" name="name_en" value="{{old('name_en')}}" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="slug">{{trans('back.slug')}}</label>
                            <b class="text-danger">*</b>
                            <input id="slug" type="text" class="form-control slug" placeholder="{{trans('back.slug')}}" name="slug" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">{{trans('back.Status')}}</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == 1 ? 'selected' : null }}>{{trans('back.Active')}}</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : null }}>{{trans('back.Inactive')}}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_ar">{{trans('back.body_ar')}}</label>
                            <textarea id="body_ar" class="d-none" name="body_ar">{{old('body_ar')}}</textarea>
                            <div class="page-editor-shell editor-ar">
                                <div id="body_ar_editor">{!! old('body_ar') !!}</div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="body_en">{{trans('back.body_en')}}</label>
                            <textarea id="body_en" class="d-none" name="body_en">{{old('body_en')}}</textarea>
                            <div class="page-editor-shell editor-en">
                                <div id="body_en_editor">{!! old('body_en') !!}</div>
                            </div>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_description_ar">{{trans('back.meta_description_ar')}}</label>
                            <textarea class="form-control" name="meta_description_ar" rows="3">{{old('meta_description_ar')}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_description_en">{{trans('back.meta_description_en')}}</label>
                            <textarea class="form-control" name="meta_description_en" rows="3">{{old('meta_description_en')}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_keywords_ar">{{trans('back.meta_keywords_ar')}}</label>
                            <textarea class="form-control" name="meta_keywords_ar" rows="3">{{old('meta_keywords_ar')}}</textarea>
                        </div>

                        <div class="form-group col-6">
                            <label for="meta_keywords_en">{{trans('back.meta_keywords_en')}}</label>
                            <textarea class="form-control" name="meta_keywords_en" rows="3">{{old('meta_keywords_en')}}</textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-purple mt-2">{{trans('back.add_new_page')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        $("#slug").keydown(() => {
            let slug = $("#slug").val();
            let res = slug.replace(/ /g, function(x) {
                return "-";
            });
            $("#slug").val(res);
        });
    </script>

    <script src="{{ asset('backend/assets/libs/quill/quill.min.js') }}"></script>
    <script>
        (function() {
            const toolbarOptions = [
                [{ header: [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link', 'image', 'blockquote', 'code-block'],
                ['clean']
            ];

            function initQuill(editorSelector, inputSelector, direction) {
                const editorElement = document.querySelector(editorSelector);
                const inputElement = document.querySelector(inputSelector);

                if (!editorElement || !inputElement || typeof Quill === 'undefined') {
                    return null;
                }

                const quill = new Quill(editorSelector, {
                    theme: 'snow',
                    modules: {
                        toolbar: toolbarOptions
                    }
                });

                quill.root.setAttribute('dir', direction);
                quill.root.style.textAlign = direction === 'rtl' ? 'right' : 'left';
                quill.on('text-change', function() {
                    inputElement.value = quill.root.innerHTML;
                });

                inputElement.value = quill.root.innerHTML;
                return quill;
            }

            $(window).on('load', function() {
                const form = document.querySelector('form');
                const arEditor = initQuill('#body_ar_editor', '#body_ar', 'rtl');
                const enEditor = initQuill('#body_en_editor', '#body_en', 'ltr');

                if (form) {
                    form.addEventListener('submit', function() {
                        if (arEditor) {
                            document.querySelector('#body_ar').value = arEditor.root.innerHTML;
                        }
                        if (enEditor) {
                            document.querySelector('#body_en').value = enEditor.root.innerHTML;
                        }
                    });
                }
            });
        })();
    </script>

@endsection
