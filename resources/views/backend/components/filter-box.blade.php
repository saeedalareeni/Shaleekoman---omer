{{-- 
    Filter Box Component
    Usage: @include('backend.components.filter-box', [
        'title' => 'البحث والفلترة',
        'action' => route('your.route'),
        'filters' => [...],
        'buttons' => [...]
    ])
--}}

<div class="filter-box">
    <div class="filter-box-header">
        <div class="filter-box-title">
            <i class="{{ $icon ?? 'fas fa-filter' }}"></i>
            <span>{{ $title ?? 'البحث والفلترة' }}</span>
        </div>
        @if(isset($results))
            <div class="filter-results">
                <i class="fas fa-list"></i> عدد النتائج: {{ $results }}
            </div>
        @endif
    </div>
    
    <form method="GET" action="{{ $action }}" id="filterForm">
        <div class="filter-box-body">
            <div class="filter-row">
                @foreach($filters as $filter)
                    <div class="filter-col">
                        <label>
                            @if(isset($filter['icon']))
                                <i class="{{ $filter['icon'] }}"></i>
                            @endif
                            {{ $filter['label'] }}
                        </label>
                        
                        @if($filter['type'] == 'text')
                            <input type="text" 
                                   name="{{ $filter['name'] }}" 
                                   class="form-control" 
                                   value="{{ request($filter['name']) }}" 
                                   placeholder="{{ $filter['placeholder'] ?? '' }}">
                        
                        @elseif($filter['type'] == 'select')
                            <select name="{{ $filter['name'] }}" class="form-control">
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        
                        @elseif($filter['type'] == 'date')
                            <input type="date" 
                                   name="{{ $filter['name'] }}" 
                                   class="form-control" 
                                   value="{{ request($filter['name']) }}">
                        
                        @elseif($filter['type'] == 'daterange')
                            <div class="d-flex gap-2">
                                <input type="date" 
                                       name="{{ $filter['name'] }}_from" 
                                       class="form-control" 
                                       value="{{ request($filter['name'] . '_from') }}"
                                       placeholder="من">
                                <input type="date" 
                                       name="{{ $filter['name'] }}_to" 
                                       class="form-control" 
                                       value="{{ request($filter['name'] . '_to') }}"
                                       placeholder="إلى">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="filter-actions">
            {{-- Search Button --}}
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> {{ $searchText ?? 'تطبيق الفلتر' }}
            </button>
            
            {{-- Reset Button --}}
            <a href="{{ $action }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i> {{ $resetText ?? 'إعادة تعيين' }}
            </a>
            
            {{-- Additional Buttons --}}
            @if(isset($buttons))
                @foreach($buttons as $button)
                    @if($button['type'] == 'modal')
                        <button type="button" 
                                class="btn btn-{{ $button['color'] ?? 'primary' }}" 
                                data-toggle="modal" 
                                data-target="#{{ $button['target'] }}">
                            <i class="{{ $button['icon'] }}"></i> {{ $button['text'] }}
                        </button>
                    
                    @elseif($button['type'] == 'link')
                        <a href="{{ $button['href'] }}" 
                           class="btn btn-{{ $button['color'] ?? 'primary' }}">
                            <i class="{{ $button['icon'] }}"></i> {{ $button['text'] }}
                        </a>
                    
                    @elseif($button['type'] == 'dropdown')
                        <div class="btn-group">
                            <button type="button" 
                                    class="btn btn-{{ $button['color'] ?? 'info' }} dropdown-toggle" 
                                    data-toggle="dropdown">
                                <i class="{{ $button['icon'] }}"></i> {{ $button['text'] }}
                            </button>
                            <div class="dropdown-menu">
                                @foreach($button['items'] as $item)
                                    <a class="dropdown-item" 
                                       href="{{ $item['href'] ?? 'javascript:void(0)' }}"
                                       @if(isset($item['onclick'])) onclick="{{ $item['onclick'] }}" @endif>
                                        <i class="{{ $item['icon'] }}"></i> {{ $item['text'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </form>
</div>
