<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UdiDetails;
use App\Models\UdiDocument;
use Session;
use PDF;

class DashboardController extends Controller
{
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
    public function index(Request $request) {
        //phpinfo();die;
        //echo mail('chowdhury.bapparoy@gmail.com','Test mail','UDI'); die;
        /*$res=$this->getDevicesLookup('%3D%2F08717648200274%3D%2C000025%3DA99971312345600%3D>014032%3D%7D013032%26%2C1000000000000XYZ123');*/
        /*echo '<pre>';
        print_r(session()->get('di_list'));*/
        
        if(session()->has('udi_list')){
            $udiList=session()->forget('udi_list');
        }
        return view('dashboard.index');
    }

    public function getUdi(Request $request){
        $input=$request->all();
        $udi_des=$this->getDevicesLookup($input['udi']);
        $result=array();
        
        if(isset($udi_des['error'])){
            $result['status']='error';
            $result['error']=$udi_des['error'];
        }else{
            if(isset($udi_des['body']->error)){
                $result['status']='error';
                $result['error']=$udi_des['body']->error;
            }else{
                if($udi_des['body']){
                    $udi=$udi_des['body']->udi;
                    $gudid=$udi_des['body']->gudid;
                    $data=array();
                    $data['udi']=$udi->udi;
                    $data['di']=$udi->di;
                   
                    if(!empty($udi->manufacturingDate)){
                        $data['manufacturingDate']=$udi->manufacturingDate;
                    }else{
                        $data['manufacturingDate']="";
                    } 
                    if(!empty($udi->expirationDate)){
                        $data['expirationDate']=$udi->expirationDate;    
                    }else{
                        $data['expirationDate']="";
                    }
                    if(!empty($udi->serialNumber)){
                        $data['serialNumber']=$udi->serialNumber;    
                    }else{
                        $data['serialNumber']="";
                    }
                    if(!empty($udi->lotNumber)){
                        $data['lotNumber']=$udi->lotNumber;
                    }else{
                        $data['lotNumber']="";
                    }
                    
                    $data['deviceName']=$udi_des['body']->productCodes[0]->deviceName;
                    $data['manufacturerName']=$gudid->device->companyName;
                    $data['image']="";
                    $data['document']="";
                    $udi_doc_img=UdiDocument::where(['di'=>$udi->di])->first();
                    if($udi_doc_img){
                        if($udi_doc_img->image){
                            $data['image']=$udi_doc_img->image;
                        }
                        if($udi_doc_img->document){
                            $data['document']=$udi_doc_img->document;
                        }
                    }
                    $result['status']='success';
                    $this->storeToSession($data);
                    $udiList=session()->get('udi_list');
                    $result['html']=view('dashboard.udiTable', array('data'=>$udiList['di']))->render();
                    
                    //$result['html']=view('dashboard.udiTable', array('data'=>$data))->render();
                    ////////////////////////////////////////////////////////    
                    // $res=UdiDetails::createUpdate(array('udi'=>$udi->udi),$data);
                    // if($res){
                    //     $result=['success']='Found device.';
                    //     $result['data']=$data;
                    // }else{
                    //     $result['status']='error'
                    //     $result['status']='Internal DB server error!';
                    // }
                    /////////////////////////////////////////////////////////
                }else{
                    $result['status']='error';
                    $result['error']='Invalid UDI format';
                }
            }
        }
        
        return response()->json($result);
    }
    
    private function storeToSession($arr){
        $udi_list=array();
        if(session()->has('udi_list')){
            $udi_list=session()->get('udi_list');
            $repeat_flag = 0;
            foreach($udi_list['di'] as $list){
                if($list['di'] != $arr['di']){
                    $repeat_flag = 1;
                }else{
                    if($list['lotNumber'] != $arr['lotNumber']){
                        $repeat_flag = 1;
                    }else{
                        $repeat_flag = 0;
                        break;
                    }
                }
            }
            if($repeat_flag){
                $udi_list['di'][]=$arr;
            }
        }else{
            $udi_list['di'][$arr['di']]=$arr;    
        }
        
        session()->put('udi_list',$udi_list);
    }

    public function reloadUdi(Request $request){
        if(session()->has('udi_list')){
            $udiList=session()->get('udi_list');
            $result['html'] = view('dashboard.udiTable', array('data'=>$udiList['di']))->render();
        }
        $result['status']='success';
        return response()->json($result);
    }

    

    private function getDevicesLookup($udi) {
        $url='https://accessgudid.nlm.nih.gov/api/v2/devices/lookup.json?';
        
        return $res=$this->curlApiRequest($url.'udi='.$udi);
        if(isset($res['error_code'])){
            return false;  
        }else{
            return $res;
        }
    }

    private function curlParseHeaders($message_headers) {
        $header_lines = preg_split("/\r\n|\n|\r/", $message_headers);
        $headers = array();
        list(, $headers['http_status_code'], $headers['http_status_message']) = explode(' ', trim(array_shift($header_lines)), 3);
        foreach ($header_lines as $header_line)
        {
            list($name, $value) = explode(':', $header_line, 2);
            $name = strtolower($name);
            $headers[$name] = trim($value);
        }
        return $headers;
    }

    private function curlApiRequest($url='', $method='GET', $params=array(), $request_headers=array()) {
        if($params) {
            $url .= '?'.http_build_query($params);
        }
        $ch = curl_init($url);
        $safe_mode = ini_get('safe_mode');
        $open_basedir = ini_get('open_basedir');
        
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($safe_mode || $open_basedir)
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        else
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'HAC');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, $method);
        if (!empty($request_headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        //var_dump($response);
        //print_r(curl_getinfo($ch));
        curl_close($ch);
        if ($errno) return array('error'=>$error, 'error_code'=>$errno);
        list($message_headers, $message_body) = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);
        return array('header'=>$this->curlParseHeaders($message_headers),'body'=>json_decode($message_body));
    }

}