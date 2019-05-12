<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow" role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            {!! apply_filters(DASHBOARD_FILTER_MENU_NAME, \Request::route()->getName()) !!}
            @foreach ($menus = dashboard_menu()->getAll() as $menu)
                <li class="dropdown nav-item @if ($menu->active) active @endif" id="{{ $menu->id }}" @if (isset($menu->children) && $menu->children->count())data-menu="dropdown"@endif>
                    <a class="@if(isset($menu->children) && $menu->children->count()) dropdown-toggle @endif nav-link" href="{{ $menu->url }}" @if (isset($menu->children) && $menu->children->count())data-toggle="dropdown"@endif>
                        <i class="{{ $menu->icon }}"></i>
                        <span class="menu-title">{{ $menu->name }}</span>
                        @if (isset($menu->children) && $menu->children->count())
                            <span class="arrow @if ($menu->active) open @endif"></span>
                        @endif
                    </a>
                    @if (isset($menu->children) && $menu->children->count())
                        <ul class="dropdown-menu">
                            @foreach ($menu->children as $item)
                                <li data-menu="" class="@if ($item->active) active @endif" id="{{ $item->id }}">
                                    <a class="dropdown-item" href="{{ $item->url }}" data-toggle="dropdown">
                                        <i class="{{ $item->icon }}"></i>
                                        {{ $item->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>