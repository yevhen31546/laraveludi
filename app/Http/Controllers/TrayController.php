<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if(session()->has('udi_list')){
            $udiList=session()->forget('udi_list');
        }

        if ($request->ajax()) {
            $input = $request->all();
            $result = array();
            $data_array = array();

            $skus = Skubatch::where(['batch' => $input['batch_num']])->paginate(5);
            foreach ($skus as $sku) :
                // Get the udi and product name
                $expire_date = str_replace("-", "", $sku['expirydate']);
                $date = substr($expire_date, 2);
                $udi = '(01)' . $sku['gtin'] . '(17)' . $date . '(10)' . $sku['batch'];
                // $udi = '(01)00887517234049(17)220303(10)0000';
                $udi_des = $this->getDevicesLookup($udi);

                $data = [];
                $data['udi'] = $udi;
                $data['gtin'] = $sku['gtin'];
                $data['batch'] = $sku['batch'];
                $data['expirydate'] = $sku['expirydate'];
                $data['status'] = 'success';

                if (isset($udi_des['error'])) {
                    // $result['status']='error';
                    // $result['error']=$udi_des['error'];
                    $data['deviceName'] = $udi_des['error'];
                } else {
                    if (isset($udi_des['body']->error)) {
                        // $result['status'] = 'error';
                        // $result['error'] = $udi_des['body']->error;
                        $data['deviceName'] = $udi_des['body']->error;
                    } else {
                        if ($udi_des['body']) {
                            $data['deviceName'] = $udi_des['body']->productCodes[0]->deviceName;
                        } else {
                            // $result['status']='error';
                            // $result['error']='Invalid UDI format';
                            $data['deviceName'] = 'Invalid UDI format';
                        }
                    }
                }
                array_push($data_array, $data);
            endforeach;

            // $result['status'] = 'success';
             $result = view('tray.trayTable', array('data_array' => $data_array, 'skus' => $skus))->render();
             return response()->json($result);
        }

        return view('tray.index');
    }

}
