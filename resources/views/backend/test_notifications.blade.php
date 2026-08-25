@extends('backend.layouts.master')

@section('title', 'اختبار الإشعارات')

@section('content')
<div class="container">
    <h2>اختبار نظام الإشعارات</h2>
    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>معلومات الإشعارات الحالية</h4>
        </div>
        <div class="card-body">
            @php
                $totalAdmin = \App\Models\Notification::whereNull('owner_id')->count();
                $unreadAdmin = \App\Models\Notification::whereNull('owner_id')->where('is_read', 0)->count();
                $recentNotifications = \App\Models\Notification::whereNull('owner_id')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            <p><strong>إجمالي إشعارات الأدمن:</strong> {{ $totalAdmin }}</p>
            <p><strong>إشعارات غير مقروءة:</strong> {{ $unreadAdmin }}</p>
            
            <h5 class="mt-3">آخر 5 إشعارات:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>النوع</th>
                        <th>العنوان</th>
                        <th>الأيقونة</th>
                        <th>اللون</th>
                        <th>مقروء</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentNotifications as $notif)
                    <tr class="{{ !$notif->is_read ? 'table-warning' : '' }}">
                        <td>{{ $notif->id }}</td>
                        <td>{{ $notif->type }}</td>
                        <td>{{ $notif->title_ar }}</td>
                        <td><i class="{{ $notif->icon ?? 'fas fa-bell' }}"></i> {{ $notif->icon }}</td>
                        <td>
                            <span class="badge badge-{{ $notif->color ?? 'info' }}">{{ $notif->color }}</span>
                        </td>
                        <td>
                            @if($notif->is_read)
                                <span class="badge badge-success">مقروء</span>
                            @else
                                <span class="badge badge-danger">غير مقروء</span>
                            @endif
                        </td>
                        <td>{{ $notif->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>إنشاء إشعار تجريبي</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('test.notification.create') }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> إنشاء إشعار تجريبي جديد
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
