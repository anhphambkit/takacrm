<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('frontend/core/user/assets/css/login.css') }}">
    <link media="all" type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body>
    <div class="container login-page fade-in-left animated-fade-in" id="container">
        <div class="form-container sign-in-container">
            {!! Form::open(['route' => 'auth.reset.complete.post', 'method' => 'post']) !!}
                @csrf
                <h1>{{ trans('core-user::auth.reset.title') }}</h1>
                <input type="email" placeholder="Email" name="email" maxlength="256" required/>

                <input type="password" placeholder="Password" name="password" maxlength="256" required/>

                <input type="password" placeholder="Password Confirmation" name="password_confirmation" maxlength="256" required/>

                <input type="hidden" name="token" value="{{ $token }}"/>
                <button type="submit" id="login">Submit</button>
            {!! Form::close() !!}                
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Welcome to Takabook Inc Custom E-Commerce Platform, please log in and start the journey with us</p>
                    <img src="{{ theme_option('logo') }}">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var Lcms = {};
        Lcms.showNotice = function (messageType, message, messageHeader) {
            toastr.clear();

            toastr.options = {
                closeButton: true,
                positionClass: 'toast-bottom-right',
                onclick: null,
                showDuration: 1000,
                hideDuration: 1000,
                timeOut: 10000,
                extendedTimeOut: 1000,
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut'

            };
            toastr[messageType](message, messageHeader);
        };

        Lcms.languages = {
            'notices_msg': {!! json_encode(trans('core-base::notices'), JSON_HEX_APOS) !!},
        };
    </script>

    @if (session()->has('success_msg') || session()->has('error_msg') || isset($errors) || isset($error_msg))
        <script type="text/javascript">
            $(document).ready(function () {
                @if (session()->has('success_msg'))
                    Lcms.showNotice('success', '{{ session('success_msg') }}', Lcms.languages.notices_msg.success);
                @endif
                @if (session()->has('error_msg'))
                    Lcms.showNotice('error', '{{ session('error_msg') }}', Lcms.languages.notices_msg.error);
                @endif
                @if (isset($error_msg))
                    Lcms.showNotice('error', '{{ $error_msg }}', Lcms.languages.notices_msg.error);
                @endif
                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                       Lcms.showNotice('error', '{{ $error }}', Lcms.languages.notices_msg.error);
                    @endforeach
                @endif
            });
        </script>
    @endif
</body>
</html>
