<!-- fixed-top-->
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center {{ config('core-base.cms.router-prefix.is_admin') ? '' : 'front-end-header' }}">
  <div class="navbar-wrapper">
    <div class="navbar-header {{ config('core-base.cms.router-prefix.is_admin') ? '' : 'front-end-header' }}">
      <ul class="nav navbar-nav flex-row">
        @if(config('core-base.cms.router-prefix.is_admin'))
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item"><a class="navbar-brand" href="{{ url('/') }}"><img class="brand-logo" alt="modern admin logo" src="{{ (theme_option('logo')) ? theme_option('logo') : get_image_url(config('core-media.media.default-img'), 'mediumThumb') }}">
              <h3 class="brand-text">{{ theme_option('name') }}</h3></a>
          </li>
          <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        @else
          <li class="nav-item nav-logo">
            <a class="navbar-brand" href="{{ url('/') }}">
              <img class="brand-logo" alt="modern admin logo" src="{{ (theme_option('logo')) ? theme_option('logo') : get_image_url(config('core-media.media.default-img'), 'mediumThumb') }}">
            </a>
          </li>
          <li class="nav-item">
            <h3 class="brand-text">{{ theme_option('name') }}</h3>
            <h6 class="brand-text">{{ theme_option('phone') }}</h6>
            <h6 class="brand-text">{{ theme_option('address') }}</h6>
          </li>
        @endif
      </ul>
    </div>
    @if(config('core-base.cms.router-prefix.is_admin'))
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            @include('navbars.nav-left')
          </ul>
          <ul class="nav navbar-nav float-right">
            @include('navbars.nav-right')
          </ul>
        </div>
      </div>
    @endif
  </div>
</nav>