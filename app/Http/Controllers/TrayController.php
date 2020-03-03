<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UdiDocument;
use App\Skubatch;


class TrayController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
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

    private function getDevicesLookup($udi) {
        $url='https://accessgudid.nlm.nih.gov/api/v2/devices/lookup.json?';

        if(isset($res['error_code'])){
            return false;
        }else{
            return $res=$this->curlApiRequest($url.'udi='.$udi);
        }
    }

    public function getBatch(Request $request){
        if(session()->has('tray_udi_list')){
            $udiList=session()->forget('tray_udi_list');
        }

        if ($request->ajax()) {
            $input = $request->all();
            $data_array = array();

            $index = 0;
            $tray_udi_list=array();
            $skus = Skubatch::where(['batch' => $input['batch_num']])->paginate(5);
            foreach ($skus as $sku) :
                // Get the udi and product name
                $expire_date = str_replace("-", "", $sku['expirydate']);
                $date = substr($expire_date, 2);
                $sku_udi = '(01)' . $sku['gtin'] . '(17)' . $date . '(10)' . $sku['batch'];
                // $udi_des = $this->getDevicesLookup($sku_udi);
                $udi = '(01)00887517234049(17)220303(10)0000';
                $udi_des = $this->getDevicesLookup($udi);

                if (isset($udi_des['error'])) {
                     $source['status']='error';
                     $source['error']=$udi_des['error'];
                } else {
                    if (isset($udi_des['body']->error)) {
                         $source['status'] = 'error';
                         $source['error'] = $udi_des['body']->error;
                    } else {
                        if ($udi_des['body']) {

                            // Api result
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

                            // database result
                            $source = array();
                            $source['status'] = 'success';
                            $source['date'] = $date;
                            $source['udi'] = $udi->udi;
                            $source['gtin'] = $sku['gtin'];
                            $source['batch'] = $sku['batch'];
                            $source['expirydate'] = $sku['expirydate'];
                            $source['deviceName']=$udi_des['body']->productCodes[0]->deviceName;

                            // Store to session
                            /*
                            if(session()->has('tray_udi_list')){
                                $tray_udi_list=session()->get('udi_list');
                                $repeat_flag = 0;
                                foreach($tray_udi_list['di'] as $list){
                                    if($list['di'] != $data['di']){
                                        $repeat_flag = 1;
                                    }else{
                                        if($list['lotNumber'] != $data['lotNumber']){
                                            $repeat_flag = 1;
                                        }else{
                                            $repeat_flag = 0;
                                            break;
                                        }
                                    }
                                }
                                if($repeat_flag){
                                    $tray_udi_list['di'][]=$data;
                                }
                            }else{
                                $tray_udi_list['di'][$data['di']]=$data;
                            }
                            */
                            $tray_udi_list['di'][$index]=$data;
                            $tray_udi_list['sku_db'][$index]=$source;
                            $index++;


                        } else {
                            $source['status']='error';
                            $source['error']='Invalid UDI format';
                        }
                    }
                }
                array_push($data_array, $source);
            endforeach;

            session()->put('tray_udi_list', $tray_udi_list);

            $result = view('tray.trayTable', array('data_array' => $data_array, 'skus' => $skus))->render();
            return response()->json($result);
        }

        return view('tray.index');
    }

}
