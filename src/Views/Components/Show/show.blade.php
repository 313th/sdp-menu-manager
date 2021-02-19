<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ env('APP_URL').'/'.env('ADMIN_URL') }}" class="nav-link @if(Request::url() == env('APP_URL').'/'.env('ADMIN_URL')) active @endif">
                <i class="nav-icon fa fa-th"></i>
                <p>
                    پیشخوان
                    <span class="right badge badge-danger">صفحه اصلی</span>
                </p>
            </a>
        </li>
        @foreach($menus as $menu)
            <li id="{{ $menu->name }}" class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-{{ $menu->icon }}"></i>
                    <p>
                        {{ $menu->title }}
                        <i class="right fa fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach($menu->my_items as $item)
                            <li id="{{ $item->name }}" class="nav-item">
                                <a href="{{ route($item->route) }}" class="nav-link @if(Request::url() == route($item->route)) active @endif">
                                    <i class="fa fa-{{ $item->icon }} nav-icon"></i>
                                    <p>{{ $item->title }}</p>
                                </a>
                            </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</nav>
<!-- /.sidebar-menu -->
