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
        CURLOPT_POSTFIELDS => array('device_id' => 'dbc647e113fa3808b01c3a9d837a8151','number' => $no_hp,'message' => $pesan),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
    }

}
        