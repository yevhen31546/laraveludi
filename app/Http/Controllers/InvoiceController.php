<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Seller;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $udi_list=session()->get('udi_list');
        
        //var_dump($udi_list); exit;
        
        // Getting GUDID
        $di_list = $udi_list['di'];        
        $url='https://accessgudid.nlm.nih.gov/api/v2/devices/lookup.json?';
        
        $invoice_list = [];
        $i = 0;
        
        foreach($di_list as $di){
            $buf = [];
            $json = file_get_contents($url.'di='.$di['di']);
            $gudid = json_decode($json, true);
            
            // get item name (gmdnPTName)
            $gmdn = $gudid['gudid']['device']['gmdnTerms']['gmdn'];
            $gmdnPTName = $gmdn[0]['gmdnPTName'];
            
            // get Catalog Number
            $catalogNumber = $gudid['gudid']['device']['catalogNumber'];
            if($catalogNumber == null){
                $catalogNumber = "(nothing)";
            }
            array_push($buf, $gmdnPTName, $catalogNumber);
            array_push($invoice_list, $buf);
        }   
        
        return view('invoice.index', compact('invoice_list'));
        //return view('invoice.index')->with("itemName", $gmdnPTName)->with("catalogNumber", $catalogNumber);
    }

    public function generate_invoice(Request $request){
        $invoice_data = $request->all();
        // cutting period of di : period = 4
        $i = 0;
        $j = 1;
        $invoices = []; // input value array
        $buf = [];
        
        foreach($invoice_data as $invoice){
            if($i > 5){
                array_push($buf, $invoice);
                if($j % 4 == 0){
                    array_push($invoices, $buf);
                    $buf = [];
                }
                $j++;
            } 
            $i++;
        }
        
        $udi_list = session()->get('udi_list');
        
        $patientName = $udi_list['other']['patient_name'];
        $patientAddress = $udi_list['other']['patient_address'];
        $patientHealthInstitution = $udi_list['other']['helthcare_name'];
        $patientHealthAddress = $udi_list['other']['helthcare_address'];
        $patientCaseNumber = $udi_list['other']['case_number'];
        $patientDate = $udi_list['other']['surgery_date'];
        $patientSurgeon = $udi_list['other']['surgeon'];
        $patientProcedure = $udi_list['other']['procedure'];
        
        $customer = new Buyer([
            'name' => $patientName,
            'address' => $patientAddress,
            'healthInstitution' => $patientHealthInstitution,
            'healthAddress' => $patientHealthAddress,
            'caseNumber' => $patientCaseNumber,
            'date' => $patientDate,
            'surgeon' => $patientSurgeon,
            'procedure' => $patientProcedure,
            //// Seller
            'companyRepresentative' => $invoice_data['company_representative'],
            'companyName' => $invoice_data['company_name'],
            'companyPhoneNumber' => $invoice_data['company_phone_number'],
            'companyEmailAddress' => $invoice_data['company_email_address'],
            'companyAddress' => $invoice_data['company_address'],
        ]);

        $items = [];
        
        foreach($invoices as $invoice){
            $item = (new InvoiceItem())->itemName($invoice['0'])->catalogNumber($invoice['1'])->quantity($invoice['2'])->pricePerUnit($invoice['3']);
            array_push($items, $item);
        }
        
        $invoice_result = Invoice::make()
            ->buyer($customer)
            ->addItems($items)
            ->currencySymbol('$')
            ->currencyCode('USD');
        
        return $invoice_result->stream();
    }
}
