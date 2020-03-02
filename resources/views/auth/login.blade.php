@extends('layouts.app')

@section('title', app_name())

@section('content')
    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container_box">
            <div class="logo_area d-block pt-5">
                <h1 class="text-center"> <img src="images/UDI_LOGO.png" alt="logo"/> </h1>
            </div>
            <div class="signin-content">

                <div class="signin-image">
                    <!--<figure><img src="images/signin-image.jpg" alt="sing up image"></figure>-->
                    <figure><img src="images/person_logo.png" alt="Nuvasive login page"></figure>
                    <!--<a href="#" class="signup-image-link">Create an account</a>-->
                </div>
                <div class="signin-form">
                    <h2 class="form-title">@lang('labels.login.box_title')</h2>
                    {{ html()->form('POST', route('login.post'))->attribute('id', 'login')->open() }}
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            {{ html()->email('email')
                                    ->placeholder(__('validation.attributes.email'))
                                    ->attribute('id', 'email')
                                    ->required() }}
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            {{ html()->password('password')
                                    ->placeholder(__('validation.attributes.password'))
                                    ->attribute('id', 'password')
                                    ->required() }}
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="checkbox" name="remember" id="remember" class="agree-term" />
                                    <label for="remember" class="label-agree-term"><span><span></span></span>@lang('labels.login.remember_me')</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <span for="forgot_pass" class="label-agree-term text-right d-block mt-1 text-primary"> <a href="{{ route('password.email') }}"> @lang('labels.passwords.forgot_password') </a> </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="@lang('labels.login.submitbtn')" />
                        </div>
                    {{ html()->form()->close() }}

                </div>
            </div>
        </div>
    </section>
@endsection

