<style>
    @media (max-width: 993px) {
        .ks-navbar div.navbar-brand .ks-navbar-logo{
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>
<nav class="navbar ks-navbar" style="z-index: 999;">
    <!-- BEGIN HEADER INNER -->
    <!-- BEGIN LOGO -->
    <div href="index.html" class="navbar-brand">
        <a href="#" class="ks-sidebar-mobile-toggle"><i class="ks-icon la la-bars" aria-hidden="true"></i></a>
        <div class="ks-navbar-logo">
            @if(!auth()->user()->isMover())
            <a href="{{ route(config('agoyu.namspace_web_router').'homepage') }}" class="ks-logo"><img src="{{ asset('packages/frontend/app-assets/img/logo.png')}}" alt="Agoyu Logo" height="40"></a>
            @else
            <a href="{{ route('web.mover.profile.get') }}" class="ks-logo"><img src="{{ asset('packages/frontend/app-assets/img/logo.png')}}" alt="Agoyu Logo" height="40"></a>
            @endif

        </div>
    </div>
    <!-- END LOGO -->

    <!-- BEGIN MENUS -->
    <div class="ks-wrapper">
        <nav class="nav navbar-nav d-block">
            <div class="ks-navbar-actions" style="float: right;">
                <div class="nav-item dropdown ks-user">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span>
                            <img src="<?php echo showImgStorage(auth()->user()->avatar_link) ?>" class="ks-avatar user-avatar-sync" width="36" height="36">
                        </span>
                        <span class="ks-info">
                            <span class="ks-name">{{ auth()->user()->username }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Preview">
                        <!-- @if(auth()->user()->isConsumer())
                            <a class="dropdown-item" href="{{ URL::route('web.consumer.profile.get') }}">
                                <span class="la la-user ks-icon"></span>
                                <span>Profile</span>
                            </a>
                        @elseif(auth()->user()->isMover())
                            <a class="dropdown-item" href="{{ URL::route('web.mover.profile.get') }}">
                                <span class="la la-user ks-icon"></span>
                                <span>Profile</span>
                            </a>
                        @endif -->
                        @if(auth()->user()->isAgoyu())
                            <a class="dropdown-item" href="{{ URL::route('agoyu.portal.user.agoyu_user_profile') }}">
                                <span class="la la-user ks-icon"></span>
                                <span>Profile</span>
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}" id="logout" onclick="localStorage.removeItem('isLogged')">
                            <span class="la la-sign-out ks-icon" aria-hidden="true"></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- BEGIN NAVBAR ACTIONS TOGGLER -->
        <nav class="nav navbar-nav ks-navbar-actions-toggle">
            <a class="nav-item nav-link" href="#">
                <span>
                    <img src="/default-avatar-user.png" class="ks-avatar" width="36" height="36">
                </span>
                <!-- <span class="la la-close ks-icon ks-close"></span> -->
            </a>
        </nav>
        <!-- END NAVBAR ACTIONS TOGGLER -->
    </div>
    <!-- END MENUS -->
    <!-- END HEADER INNER -->
</nav>