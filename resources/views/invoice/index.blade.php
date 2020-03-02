@extends('layouts.app')

@section('title', app_name())

@section('content')
    <section class="dashboard">
        <div class="container">
            <div class="container_box">
                <div class="col-12"> <a title="Logout" id="logout" class="btn float-right mt-3 mr-3" href="{{ route('logout') }}"><i class="zmdi zmdi-power"></i></a></div>
                <div class="logo_area d-block pt-5">
                    <h1 class="text-center"> <img src="{{ url('images/UDI_LOGO.png') }}" alt="logo"/> </h1>
                </div>
               
                <div class="table_inside" id="invoice">                   
                    {{ html()->form('POST', route('generate_invoice'))->attribute('class', 'invoice_form')->attribute('name', 'invoice')->open() }}
                    
                        <div class="table_seller">
                            <div class="row a">
                                <div class="col-6 up">
                                    <span>Company Representative</span>
                                </div>
                                <div class="col-6 down">
                                    <input type="text" id="company_representative" name="company_representative" required>
                                </div>
                            </div>
                            <div class="row b">
                                <div class="col-6 up">
                                    <span>Company</span>
                                </div>
                                <div class="col-6 down">
                                    <input type="text" id="company_name" name="company_name" required>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-6 up">
                                    <span>Phone Number</span>
                                </div>
                                <div class="col-6 down">
                                    <input type="text" id="company_phone_number" name="company_phone_number" required>
                                </div>
                            </div>
                            <div class="row b">
                                <div class="col-6 up">
                                    <span>Email Address</span>
                                </div>
                                <div class="col-6 down">
                                    <input type="text" id="company_email_address" name="company_email_address" required>
                                </div>
                            </div>
                            <div class="row a">
                                <div class="col-6 up">
                                    <span>Address</span>
                                </div>
                                <div class="col-6 down">
                                    <input type="text" id="company_address" name="company_address" required>
                                </div>
                            </div>
                        </div>
                    
                        <div class="table_th row pc">
                            <div class="col-3">Item Name</div>
                            <div class="col-3">Catalog Number</div>
                            <div class="col-3">Quantity of DI</div>
                            <div class="col-3">Price</div>
                        </div>
                        
                        <?php $i=0;?>
                        @foreach($invoice_list as $invoice) 
                        <div class="each-di">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="quantity_di"><i class="zmdi zmdi-collection-item material-icons-name"></i></label>
                                        {{ html()->text('item_name'.'_'.$i)
                                            ->placeholder('Item Name')
                                            ->attribute('class', 'item_name')
                                            ->attribute('value', (isset($invoice[0])?$invoice[0]:''))
                                            ->attribute('required', '')
                                        }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="catalog_number"><i class="zmdi zmdi-format-list-numbered material-icons-name"></i></label>
                                        {{ html()->text('catalog_number'.'_'.$i)
                                            ->placeholder('Catalog Number')
                                            ->attribute('class', 'catalog_number')
                                            ->attribute('value', (isset($invoice[1])?$invoice[1]:'')) 
                                            ->attribute('required', '')
                                        }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="quantity_di"><i class="zmdi zmdi-collection-item-9-plus material-icons-name"></i></label>
                                        {{ html()->text('quantity_di'.'_'.$i)
                                            ->placeholder('Quantity of DI')
                                            ->attribute('class', 'quantity_di')
                                            ->attribute('value', (isset($quantity_di)?$quantity_di:''))
                                            ->attribute('required', '')
                                        }}
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="catalog_number"><i class="zmdi zmdi-paypal-alt material-icons-name"></i></label>
                                        {{ html()->text('price'.'_'.$i)
                                            ->placeholder('Price')
                                            ->attribute('class', 'price')
                                            ->attribute('value', (isset($price)?$price:'')) 
                                            ->attribute('required', '')
                                        }}
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <?php $i++;?>
                        @endforeach
                        
                        <div class="form-group mt-3 d-black text-center mb-0">
                            {{ form_submit(__('labels.dashboard.submitbtn'),'btn form-submit') }}
                        </div>
                    {{ html()->form()->close() }}
                    
                    <div class="go-dashboard mt-3 d-black text-center mb-0">
                        <a href="{{ url('/dashboard') }}" class="btn go-btn">Go Dashboard</a>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>
@endsection
