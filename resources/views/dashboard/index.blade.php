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
                    {{ html()->form('POST', route('getudi'))->attribute('id', 'frm_udi')->attribute('name', 'udi_search')->open() }}
                        <div class="row">
                            <div class="col-11">
                                <div class="form-group">
                                    <label for="udi"><i class="zmdi zmdi-floppy material-icons-name"></i></label>
                                    {{ html()->text('udi')
                                        ->placeholder('Udi')
                                        ->attribute('id', 'udi')
                                        ->attribute('value', (isset($udi)?$udi:''))
                                        ->required() 
                                    }}
                                    
                                    <span><i class="zmdi zmdi-help-outline"></i></span>
                                </div>
                            </div>
                            <div class="col-1">
                                <button id="scan_udi" class="btn btn-defult" type="button">Scan</button>
                            </div>
                        </div>
                    {{ html()->form()->close() }}
                    <div class="camera-section">
                        <div id="scandit-barcode-picker" class="scandit-barcode-picker"></div>
                        <div id="scandit-barcode-result">No codes scanned yet</div>
                        <!--<div class="continue-bt">
                            <button id="continue-scanning-button" onclick="continueScanning()">
                                Continue Scanning
                            </button>
                        </div>-->
                    </div>
                    {{ html()->form('POST', route('card'))->attribute('id', 'card')->attribute('name', 'card')->open() }}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="patient_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    {{ html()->text('patient_name')
                                        ->placeholder('Patient Name')
                                        ->attribute('id', 'patient_name')
                                        ->attribute('value', (isset($patient_name)?$patient_name:''))
                                    }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="patient_address"><i class="zmdi zmdi-my-location material-icons-name"></i></label>
                                    {{ html()->text('patient_address')
                                        ->placeholder('Address')
                                        ->attribute('id', 'patient_address')
                                        ->attribute('value', (isset($patient_address)?$patient_address:'')) 
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="helthcare_name"><i class="zmdi zmdi-hospital material-icons-name"></i></label>
                                    {{ html()->text('helthcare_name')
                                        ->placeholder(' Healthcare institution/provider')
                                        ->attribute('id', 'helthcare_name')
                                        ->attribute('value', (isset($helthcare_name)?$helthcare_name:''))
                                    }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="helthcare_address"><i class="zmdi zmdi-my-location material-icons-name"></i></label>
                                    {{ html()->text('helthcare_address')
                                        ->placeholder('Healthcare Address')
                                        ->attribute('id', 'helthcare_address')
                                        ->attribute('value', (isset($helthcare_address)?$helthcare_address:'')) 
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="case_number"><i class="zmdi zmdi-card-giftcard material-icons-name"></i></label>
                                    {{ html()->text('case_number')
                                        ->placeholder('Case Number')
                                        ->attribute('id', 'case_number')
                                        ->attribute('value', (isset($case_number)?$case_number:''))
                                        ->required() 
                                    }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="surgery_date"><i class="zmdi zmdi-calendar material-icons-name"></i></label>
                                    {{ html()->date('surgery_date')
                                        ->placeholder('Surgery Date')
                                        ->attribute('id', 'surgery_date')
                                        ->attribute('value', (isset($surgery_date)?$surgery_date:''))
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="surgeon"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    {{ html()->text('surgeon')
                                        ->placeholder('Surgeon')
                                        ->attribute('id', 'surgeon')
                                        ->attribute('value', (isset($surgeon)?$surgeon:'')) 
                                    }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="procedure"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    {{ html()->text('procedure')
                                        ->placeholder('Procedure')
                                        ->attribute('id', 'procedure')
                                        ->attribute('value', (isset($procedure)?$procedure:'')) 
                                    }}
                                </div>
                            </div>
                        </div>
                        <div id="results">
                            <table class=" table table-striped table-bordered mt-3" id="udiTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Device Id</th>
                                        <th scope="col">Device Name</th>
                                        <th scope="col">Manufacturing Date</th>
                                        <th scope="col">Expiration Date</th>
                                        <th scope="col">Batch Number</th>
                                        <th scope="col">Serial Number</th>
                                        <th scope="col">Manufacturer Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">IFU</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <!--- invoice --->
                        <div class="invoice_check_part">     
                            <input type="checkbox" id="invoice_check" name="invoice_check" value="invoice_check">
                            <label for="invoice_check">Generate the invoice pdf.</label>
                        </div>
                        
                        <div class="form-group mt-3 d-black text-center mb-0">
                            {{ form_submit(__('labels.dashboard.submitbtn'),'btn form-submit') }}
                        </div>
                    {{ html()->form()->close() }}
                </div>
                
                <div class="warning-background">
                    <div class="warning">
                        You can scan UDI automatically with the camera by clicking the "Scan" button, or type UDI manually.
                        If once UDI is scanned or typed, please click the "Scan" button.
                        Then GUDID info will be inserted into the bottom table.
                        Multiple scannings are possible.
                        <div><button class="btn form-submit no">Close</button></div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
@endsection
@push('after-scripts')
    {!! script('js/custom.js') !!}
@endpush