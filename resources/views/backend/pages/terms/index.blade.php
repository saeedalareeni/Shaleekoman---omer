@extends('backend.layouts.master')

@section('title')
{{ __('back.terms_and_policies') }}
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4>{{ __('back.terms_and_policies') }}</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('terms.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('back.add_new_page') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">{{ __('back.title') }}</th>
                                <th width="15%">{{ __('back.type') }}</th>
                                <th width="10%">{{ __('back.version') }}</th>
                                <th width="15%">{{ __('back.effective_date') }}</th>
                                <th width="5%">{{ __('back.order') }}</th>
                                <th width="10%">{{ __('back.status') }}</th>
                                <th width="15%">{{ __('back.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($terms as $term)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ __('back.arabic') }}:</strong> {{ $term->title_ar }}<br>
                                    <strong>{{ __('back.english') }}:</strong> {{ $term->title_en }}
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $term->type_label }}</span>
                                </td>
                                <td>{{ $term->version }}</td>
                                <td>{{ $term->effective_date ? $term->effective_date->format('Y-m-d') : '-' }}</td>
                                <td>{{ $term->order }}</td>
                                <td>
                                    <form action="{{ route('terms.toggle-status', $term->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $term->is_active ? 'btn-success' : 'btn-danger' }}">
                                            {{ $term->is_active ? __('back.active') : __('back.inactive') }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('terms.edit', $term->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('terms.destroy', $term->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('{{ __('back.are_you_sure_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">{{ __('back.no_pages') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
