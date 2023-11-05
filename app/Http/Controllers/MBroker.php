<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MBroker extends Controller
{

    public function send($no_hp, $pesan){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.whacenter.com/api/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('device_id' => '0eb2901eacc5ddbf1f205fc5fed0ee50','number' => $no_hp,'message' => $pesan),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
    }

}
        