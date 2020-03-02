@extends('layouts.app')

@section('title', app_name())

@section('content')
    {{-- <div class="row justify-content-center align-items-center">
        <div class="col col-sm-6 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.passwords.reset_password_box_title')
                    </strong>
                </div>

                <div class="card-body">

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ html()->form('POST', route('password.reset.update'))->class('form-horizontal')->open() }}
                        {{ html()->hidden('token', $token) }}

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.email'))->for('email') }}

                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.email'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.password'))
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.password_confirmation'))
                                        ->required() }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    {{ form_submit(__('labels.passwords.reset_password_button')) }}
                                </div>
                            </div>
                        </div><
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </div> --}}

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
                {{ html()->form('POST', route('password.reset.update'))->class('form-horizontal')->open() }}
                    {{ html()->hidden('token', $token) }}
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        {{ html()->email('email')
                            ->class('')
                            ->placeholder(__('validation.attributes.email'))
                            ->attribute('maxlength', 191)
                            ->required() 
                        }}
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-lock"></i></label>
                        {{ html()->password('password')
                            ->class('')
                            ->placeholder(__('validation.attributes.password'))
                            ->required() 
                        }}
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-lock"></i></label>
                        {{ html()->password('password_confirmation')
                            ->class('')
                            ->placeholder(__('validation.attributes.password_confirmation'))
                            ->required() 
                        }}
                    </div>
                    <div class="form-group form-button">
                        {{ form_submit(__('labels.passwords.reset_password_button'),'form-submit') }}
                    </div>
                {{ html()->form()->close() }}
            </div>
        </div>
    </div>
</section>
@endsection
