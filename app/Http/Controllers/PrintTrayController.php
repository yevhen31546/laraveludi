<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use PDF;
use Storage;

class PrintTrayController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function printTray(Request $request){
        $input = $request->all();
        if(session()->has('tray_udi_list')){
            $udi_list=session()->get('tray_udi_list');
            $udi_list['other'] = $input;
            PDF::SetTitle("Tray");
            $this->trayCard($udi_list);
            //session()->forget('tray_udi_list');
        }
        return redirect('tray');
    }

    private function trayCard($udi_list){
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        PDF::SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
        // Get udi information
        $udi_contents = array();
        $size = 3;
        foreach ($udi_list['di'] as $di) {
            $url = 'https://accessgudid.nlm.nih.gov/api/v2/devices/lookup.json?';
            $json = file_get_contents($url . 'di=' . $di['di']);
            $obj = json_decode($json, true);

            // QR code
            $qr_str = $di['udi'];
            $image = \QrCode::format('png')
                ->size(200)->errorCorrection('H')
                ->generate($qr_str);
            $filename = time() . '.png';
            Storage::disk('public')->put($filename, $image);
            $qr_url = url('/qr-codes/' . $filename);

            $temp['obj'] = $obj;
            $temp['qr_url'] = $qr_url;

            array_push($udi_contents, $temp);
        }

        // generate PDF
        $pages = intdiv(count($udi_contents), $size) + 1;
        $page_segment = array_chunk($udi_contents, $size);
        $sku_segment = array_chunk($udi_list['sku_db'], $size);
        for ($i=0; $i<$pages; $i++) {
            $page_content = $page_segment[$i];
            $sku_db = $sku_segment[$i];
            // PDF Body
            /*$pdf_html = view('tray.printTray', array('page_content' => $page_content,
                'sku_db' => $sku_db, 'other' => $udi_list['other']))->render();
            */
            PDF::AddPage('P', 'A4');
            //PDF::writeHTML($pdf_html, true, false, true, false, '');

            // Generate Header
            PDF::SetFont('', '', 9, '', true);
            PDF::SetXY(10, 10);
            PDF::Write(0, 'NUVASIVE,INC.');

            PDF::SetFont('', '', 9, '', true);
            PDF::SetXY(90, 10);
            PDF::Write(0, 'TRAY XXXXXX');

            PDF::SetFont('', '', 9, '', true);
            PDF::SetXY(175, 10);
            PDF::Write(0, 'YYYY-MM-DD');

            // Generate tag
//            $tag_outline = array('width' => 1, 'dash' => '2,10', 'color' => array(0, 0, 0));
//            PDF::Text(100, 4, 'Rectangle examples');
//            PDF::Rect(10, 10, 144, 144, 'DF', $tag_outline, array(220, 220, 200));



        }
        PDF::Output('tray.pdf', 'I');
    }

}
