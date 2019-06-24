<li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
        <span class="mr-1">Hello,<span class="user-name text-bold-700">{{ \Illuminate\Support\Facades\Auth::user()->username }}</span></span><span class="avatar avatar-online">
            <img src="{{ (\Illuminate\Support\Facades\Auth::check()) ? get_image_url(\Illuminate\Support\Facades\Auth::user()->profile_image, 'mediumThumb', false, config('core-media.media.default-img')) : get_image_url(config('core-media.media.default-img'), 'mediumThumb') }}" alt="avatar"><i></i></span></a>
    <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#"><i class="ft-user"></i> Edit Profile</a><a class="dropdown-item" href="#"><i class="ft-mail"></i> My Inbox</a><a class="dropdown-item" href="#"><i class="ft-check-square"></i> Task</a><a class="dropdown-item" href="#"><i class="ft-message-square"></i> Chats</a>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i class="ft-power"></i> Logout</a>
    </div>
</li>