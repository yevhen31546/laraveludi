@extends('layouts.app')

@section('title', app_name())

@section('content')
    <!-- Sign up form -->
        <section class="signup">
            <div class="container_box">
                <div class="logo_area d-block pt-5">
                    <h1 class="text-center"> <img src="images/UDI_LOGO.png" alt=""/> </h1>
                </div>
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">@lang('labels.register.box_title')</h2>
                        {{ html()->form('POST', route('register.post'))->attribute('id', 'register')->open() }}
                            <div class="form-group">
                                <label for="first_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                {{ html()->text('first_name')
                                        ->placeholder(__('validation.attributes.first_name'))
                                        ->attribute('maxlength', 50)
                                        ->attribute('id', 'first_name')
                                        ->required() }}
                            </div>
                            <div class="form-group">
                                <label for="last_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                {{ html()->text('last_name')
                                        ->placeholder(__('validation.attributes.last_name'))
                                        ->attribute('maxlength', 50)
                                        ->attribute('id', 'last_name')
                                        ->required() }}
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                {{ html()->email('email')                                        ->placeholder(__('validation.attributes.email'))
                                        ->attribute('maxlength', 150)
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
                            <div class="form-group">
                                <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                                {{ html()->password('password_confirmation')
                                        ->placeholder(__('validation.attributes.password_confirmation'))
                                        ->attribute('id', 'password_confirmation')
                                        ->required() }}
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree_termcond" id="agree_termcond" class="agree-term" />
                                <label for="agree_termcond" class="label-agree-term"><span><span></span></span>@lang('labels.register.agree_terms_cond')</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="@lang('labels.register.submitbtn')" />
                            </div>
                        {{ html()->form()->close() }}
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="{{route('login')}}" class="signup-image-link">@lang('labels.register.already_member')</a>
                    </div>
                </div>
            </div>
        </section>

@endsection
