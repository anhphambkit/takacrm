<li class="dropdown nav-item {{ $active ? 'active' : ''}}" data-menu="dropdown">
	<a class="dropdown-toggle nav-link" href="{{ URL::route($route) }}" data-toggle="dropdown">
		<i class="la la-home"></i>
		<span class="menu-title" data-i18n="">{{ $title }}</span>
	</a>
</li>