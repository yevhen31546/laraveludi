@extends('layouts.app')

@section('title', app_name())

@section('content')
    <section>
        <div class="container_box">
            <div class="logo_area d-block pt-5">
                <h1 class="text-center"> <img src="images/UDI_LOGO.png" alt=""/> </h1>
            </div>
            <div class="success_inside">
                <form class="table_inside_form mb-0">
                    <div class="success_inside_msg">
                        <h4 class="text-center">SUCCESS!</h4>
                        <p class="text-center mt-3">Your card has been confirmed. Check your email for detials.</p>
                        <h5 class="print_box"><a target="_blank" href="{{ url('/printcard') }}">PRINT PATIENT CARD AND PAMPHLET</a></h5>

                        @if($invoice_flag)
                            <div class="form-group mt-3 d-black text-center mb-0">
                                <a href="{{ url('/invoice') }}" class="btn form-submit">Generate Invoice PDF</a>
                            </div>
                        @endif

                        <div class="form-group mt-3 d-black text-center mb-0">
                            <!--<a href="{{ url('/dashboard') }}" class="btn form-submit">New Case</a>-->
                            <button class="btn form-submit newCase">New Case</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="warning-background">
                <div class="warning">
                    <div class="txt">
                        If you select new case, it will be lead to the Dashboard page but you will be lost all data.
                        Would you quite really?
                    </div>
                    <div class="btns row">
                        <div class="col-6">
                            <a href="{{ url('/dashboard') }}" class="btn form-submit">Yes</a>
                        </div>
                        <div class="col-6">
                            <button class="btn form-submit no">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('after-scripts')
    {!! script('js/custom.js') !!}
@endpush