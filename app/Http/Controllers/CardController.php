<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UdiDetails;
use App\Models\UdiDocument;
use Session;
use PDF;
use Storage;

class CardController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth']);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request){
<<<<<<< HEAD
        $input=$request->all();
        $udi_list=array();
        if(session()->has('udi_list')){
            $udi_list=session()->get('udi_list');
            dd($udi_list); exit;
=======
        $input=$request->all();        
        $udi_list=array();        
        if(session()->has('udi_list')){
            $udi_list=session()->get('udi_list');
>>>>>>> 4366a51618bea847313d4e31f4595da4640f75af
            $udi_list['other']=$input;
            session()->put('udi_list',$udi_list);
            $invoice_flag = false;
            if(in_array("invoice_check", $input)){
                $invoice_flag = true;
            }            
            return view('card.index')->with('invoice_flag', $invoice_flag);
        }

        return redirect('dashboard');
    }

    public function printCard(Request $request){
        if(session()->has('udi_list')){
            $udi_list=session()->get('udi_list');
<<<<<<< HEAD
=======
            
>>>>>>> 4366a51618bea847313d4e31f4595da4640f75af
            PDF::SetTitle('Card');
            $this->frontCard($udi_list);
            foreach ($udi_list['di'] as $value) {
                $this->backCard($value);
            }
            //$this->backCard($udi_list);
            $udiList=session()->forget('udi_list');
            PDF::Output('card.pdf', 'I'); 
        }
        return redirect('dashboard');
    }

    private function frontCard($udi_list){
        PDF::AddPage();
        PDF::Image(url('/card_bg/card_f.jpg'),60,50,85.6,54);
        PDF::SetFont('', 'B', 12, '', true);
        PDF::SetXY(65, 55);
        PDF::Write(0, $udi_list['other']['case_number']);
        PDF::SetFont('', '', 9, '', true);
        PDF::SetXY(100, 55);
        PDF::Write(0,'International Implant Card');
        
        PDF::SetFont('', '', 10, '', true);
        PDF::Image(url('/card_bg/i_1.jpg'),66,62,6,6);
        PDF::SetXY(75, 63);
        PDF::Write(0,$udi_list['other']['patient_name']);
        PDF::SetXY(74, 64);
        PDF::Write(0,'________________________________');
<<<<<<< HEAD

=======
        
>>>>>>> 4366a51618bea847313d4e31f4595da4640f75af
        PDF::Image(url('/card_bg/i_2.jpg'),66,68,6,6);
        PDF::SetXY(75, 69);
        PDF::Write(0,$udi_list['other']['surgery_date']);
        PDF::SetXY(74, 70);
        PDF::Write(0,'________________________________');
        
        PDF::Image(url('/card_bg/i_3.jpg'),66,75,6,6);
        PDF::SetXY(75, 75);
        PDF::Write(0,$udi_list['other']['helthcare_name']);
        PDF::SetXY(74, 76);
        PDF::Write(0,'________________________________');
        
        PDF::SetXY(75, 81);
        PDF::Write(0,$udi_list['other']['helthcare_address']);
        PDF::SetXY(74, 82);
        PDF::Write(0,'________________________________');
        PDF::SetXY(75, 87);
        PDF::Write(0,$udi_list['other']['surgeon']);
        PDF::SetXY(74, 88);
        PDF::Write(0,'________________________________');
        
        PDF::Image(url('/card_bg/i_4.jpg'),66,93,7,7);
        PDF::SetXY(74, 95);
        PDF::SetFont('', 'I', 8, '', true);
        PDF::Write(0,'https://accessgudid.nlm.nih.gov/');
    }

    private function backCard($di){
        //$txt='en Pacemaker / bg neinciviecikbp / cs Kardiostimulator / da Pacemaker / de Schrittmacher / el Bripa-roberric / es Marcapasos / et Sudamestimulaator / fi sydamentandistin / fr Stimulateru cardiaque / hr Pejsmejker / hu Pacemaker / it Stimolatore cardiaco / is Gangverkamaour / It Birdies stimuliatorius / Iv Elektrokardiostimulators / n1 Pacemaker / no pacemaker / pI Rozrusznik serca / pt-pt Marcapasso/ ro pacemaker / sk kardiostimulator / sl Sroni spodbujevalnik / sv Pacemaker';
        /*$di_list = $udi_list['di'];
        foreach($di_list as $did){
            $di = $did;    
        }*/
        //$other_list = $udi_other;
        
        $url='https://accessgudid.nlm.nih.gov/api/v2/devices/lookup.json?';
        $json = file_get_contents($url.'di='.$di['di']);
        $obj = json_decode($json, true);
        
        $gmdn = $obj['gudid']['device']['gmdnTerms']['gmdn'];
        $gmdnPTName = $gmdn[0]['gmdnPTName'];
        $txt=$gmdnPTName;
        
        PDF::AddPage();
        PDF::Image(url('/card_bg/card_f.jpg'),60,60,85.6,54);
        // gmdnPTName
        PDF::SetXY(63, 64);
        PDF::SetFont('', '', 7, '', true);
        PDF::SetTextColor(0,112,192);
        //PDF::Write(10, $txt);
        PDF::MultiCell(83, 0, $txt, 0, 'L', 0, 0, '', '', true);
        
        // MD - device name
        PDF::Image(url('/card_bg/md.jpg'),63,83,8,4);
        PDF::SetXY(74, 83);
        PDF::SetFont('', 'B', 10, '', true);
        PDF::Write(0,$di['deviceName']);
        // udi-di
        PDF::Image(url('/card_bg/udi_di.jpg'),63,89,8,4);
        PDF::SetXY(74, 89);
        PDF::SetFont('', 'B', 10, '', true);
        PDF::Write(0,$di['di']);
        
        // udi image
        PDF::Image(url('/card_bg/udi.jpg'),120,90,5,3);
        
        // QR code
        //PDF::Image(url('/card_bg/barcode.jpg'),133,77,10,10);
        $qr_str = $di['udi'];
        $image = \QrCode::format('png')
                 ->size(200)->errorCorrection('H')
                 ->generate($qr_str);
        $filename = time() . '.png';
        /*$output_file = 'public/img/qr-code/img-'.$filename;
        Storage::disk('local')->put($output_file, $image); //storage/app/public/img/qr-code/img-1557309130.png
        $path = storage_path('public/img/qr-code/'.$filename);*/
        Storage::disk('public')->put($filename, $image);
        PDF::Image(url('/qr-codes/'.$filename),128,89,12,12);
                
        //sn 
        PDF::Image(url('/card_bg/sn.jpg'),63,95,5,4);
        PDF::SetXY(74, 95);
        PDF::SetFont('', 'B', 10, '', true);
        PDF::Write(0,$di['serialNumber']);
        // customer info
        PDF::Image(url('/card_bg/i_5.jpg'),63,101,8,8);
        PDF::SetXY(74, 101);
        PDF::SetFont('', 'B', 7, '', true);
        
        $contact = $obj['gudid']['device']['contacts']['customerContact'];
        if($contact[0]['email'] != null){
            $customer_email = $contact[0]['email'];    
        }else{
            $customer_email = "";
        }
        if($contact[0]['phone'] != null){
            $customer_phone = $contact[0]['phone'];
        }else{
            $customer_phone = "";
        }
        if($contact[0]['phoneExtension'] != null){
            $customer_extension = $contact[0]['phoneExtension'];    
        }else{
            $customer_extension = "";
        }       
        
        // phone
        PDF::SetXY(74, 101);
        PDF::SetFont('', 'B', 7, '', true);
        PDF::Write(0,$customer_email);
        // phone phoneExtension
        PDF::SetXY(74, 105);
        PDF::SetFont('', 'B', 7, '', true);
        PDF::Write(0,$customer_phone);
        // email
        PDF::SetXY(74, 109);
        PDF::SetFont('', 'B', 7, '', true);
        PDF::Write(0,$customer_extension);        
    }
}