<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset('frontend/core/user/assets/css/login.css') }}">
</head>

<body>
    <div class="container login-page fade-in-left animated-fade-in" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" />
                <input type="email" placeholder="Email" />
                <input type="password" placeholder="Password" />
                <button>Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            {!! Form::open(['route' => 'post.login', 'method' => 'post']) !!}
                @csrf
                <h1>Sign in</h1>
                <input type="text" placeholder="Email" name="username" maxlength="256" required/>
                {!! $errors->first('username', '<span class="help-block">:message</span>') !!}

                <input type="password" placeholder="Password" id="password" name="password" required/>
                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                <a href="{{ URL::route('auth.reset') }}">Forgot your password?</a>
                <button type="submit" id="login">Log in</button>
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
</body>
</html>
