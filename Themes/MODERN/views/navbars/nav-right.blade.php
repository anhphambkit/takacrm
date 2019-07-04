@if(\Auth::check())
	@php
		$avatar = \Auth::user()->profile_image;
	@endphp
@endif
<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
        <span class="mr-1">Hello,<span class="user-name text-bold-700">{{ \Illuminate\Support\Facades\Auth::user()->username }}</span></span><span class="avatar avatar-online">
            <img src="{{ $avatar ?? get_image_url(config('core-media.media.default-img'), 'mediumThumb') }}" alt="avatar"><i></i></span></a>
    <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a><a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a><a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a><a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i class="ft-power"></i> Logout</a>
    </div>
</li>