<?php

namespace App\Http\Controllers;

use App\Providers\WhatsappSch;
use Illuminate\Http\Request;

class WATestController extends Controller
{
    public function broadcast(Request $r)
    {
        
        $dest = [
            ['no' => '082339626351', 'name' => 'Erwin', 'nama_barang' => 'Asus X445', 'jumlah_gadai' => '1.000.000', 'total_tebusan' => '1.100.000', 'biaya_perpanjang' => '100.000'],
            ['no' => '082339626351', 'name' => 'Ogi', 'nama_barang' => 'Lenovo Thinkpad', 'jumlah_gadai' => '2.000.000', 'total_tebusan' => '2.200.000', 'biaya_perpanjang' => '200.000']
        ];

        $sch = date('Y-m-d H:i:s', strtotime("-1 hours", strtotime(date('Y-m-d H:i:s'))));
        $i = 0;

        foreach ($dest as $d) {
            $i += 1;
            $time = date('Y-m-d H:i:s', strtotime("+".$i." minutes", strtotime($sch)));
            // echo $time."<br>";

            $text = "SELAMAT PAGI kami dari putra mandiri cakra ingin menginformasikan kepada :\n".
                "Nama : ".$d['name'].
                "\nBarang jaminan : ". $d['nama_barang'].
                "\nJumlah gadai  : ".$d['jumlah_gadai'].
                "\nTotal tebusan : ".$d['total_tebusan'].
                "\nBiaya perpanjang : ". $d['biaya_perpanjang'].
                "\n\nBahwa barang yang di gadaikan sudah jatuh tempo hari ini per tanggal ".date('d-m-Y')."  harap untuk segera ditebus atau diperpajang untuk menghindari denda keterlabatan  10.000 / hari selama 5 hari .  Apabila barang tidak di proses  maka barang jaminan akan masuk pada tahap pelelangan.\n\n".
                "Terimakasih";
            event(new WhatsappSch($d['no'], $text, $time));
        }

        return 'done !';
    }
}
