@extends('layouts.app')

@section('title', app_name())

@section('content')
<section class="sign-in">
    <div class="container_box">
        <div class="logo_area d-block pt-5">
            <h1 class="text-center"> <img src="{{ url('/images/UDI_LOGO.png') }}" alt=""/> </h1>
        </div>
        <div class="signin-content">

            <div class="signin-image">
                <figure><img src="{{ url('/images/signup-image.jpg') }}" alt="sing up image"></figure>
                <!--<a href="#" class="signup-image-link">Create an account</a>-->
            </div>
            <div class="signin-form">
                <h2 class="form-title">@lang('labels.passwords.reset_password_box_title')</h2>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {{ html()->form('POST', route('password.email.post'))->open() }}
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        {{ html()->email('email')
                            ->class('')
                            ->placeholder(__('validation.attributes.email'))
                            ->attribute('maxlength', 191)
                            ->required()
                            ->autofocus() 
                        }}
                    </div>
                    <div class="form-group form-button">
                        {{ form_submit(__('labels.passwords.send_password_reset_link_button'),'form-submit') }}
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</section>
@endsection