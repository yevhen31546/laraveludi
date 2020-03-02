@extends('layouts.app')

@section('title', app_name())

@section('content')
    <section class="dashboard">
        <div class="container">
            <div class="container_box">
                <div class="col-12"> <a title="Logout" id="logout" class="btn float-right mt-3 mr-3" href="{{ route('logout') }}"><i class="zmdi zmdi-power"></i></a></div>
                <div class="logo_area d-block pt-5">
                    <h1 class="text-center"> <img src="{{ url('images/UDI_LOGO.png') }}" alt=""/> </h1>
                </div>

                <div class="table_inside">

                    {{ html()->form('POST', route('printtray'))->attribute('id', 'tray_form')
                                                               ->attribute('name', 'tray_form')->open() }}
                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-center">Tray</h2>
                            <div class="form-group">
                                <label for="tray"></label>
                                {{ html()->text('tray_num')
                                    ->placeholder('Tray Number')
                                    ->attribute('id', 'tray_num')
                                    ->attribute('value', (isset($tray_num)?$tray_num:''))
                                    ->required()
                                }}
                            </div>
                        </div>
                        <div class="col-2" style="margin-top: 59px;">
                            <button id="scan_tray" class="btn btn-defult" type="button">Scan</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-10">
                            <h2 class="text-center">Parts</h2>
                            <div class="form-group">
                                <label for="tray"></label>
                                {{ html()->text('batch_num')
                                    ->placeholder('Batch Number')
                                    ->attribute('id', 'batch_num')
                                    ->attribute('value', (isset($batch_num)?$batch_num:''))
                                    ->required()
                                }}
                            </div>
                        </div>
                        <div class="col-2" style="margin-top: 59px;">
                            <button id="scan_batch" class="btn btn-defult" type="button">Scan</button>
                        </div>
                    </div>
                    <div id="results">
                        <table class=" table table-striped table-bordered mt-3" id="trayTable">
                            <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">UDI</th>
                                <th scope="col">GTIN</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Expiration Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="row tray-bottom">
                        <div class="offset-3 col-md-3">
                            <button id="tray_back" class="btn btn-defult" type="button"
                                    onclick="window.location='{{ url('home') }}'">
                                Back
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button id="tray_continue" class="btn btn-defult" type="button">Continue</button>
                        </div>
                    </div>

                    {{ html()->form()->close() }}
                </div>

            </div>
        </div>
    </section>
@endsection
@push('after-scripts')
    {!! script('js/custom.js') !!}
@endpush