<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('user-index.index') }}" class="p-2 nav-link rounded-5 {{ request()->routeIs('user-index.index') ? 'active' : '' }}">
            <i class="fa fa-user"></i>
            {{ trans('back.Profile_Information') }}
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('account.orders') }}" class="p-2 nav-link rounded-5 {{ request()->routeIs('account.orders') ? 'active' : '' }}">
            <i class="fa fa-calendar"></i>
            {{ trans('back.My_booking') }}
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{ route('account.wishlist') }}" class="p-2 nav-link rounded-5 {{ request()->routeIs('account.wishlist') ? 'active' : '' }}">
            <i class="fa fa-heart"></i>
            {{ trans('back.wishlist') }}
        </a>
    </li>
</ul>
