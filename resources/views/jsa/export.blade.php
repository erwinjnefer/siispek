<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{!! $wp->users->name !!}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 8pt;
		}

        @page { margin-left: 0px; margin-right: 0px;margin-top: 24px; margin-bottom: 10px; }
        body { margin-left: 0px; margin-right: 0px;margin-top: 5px; margin-bottom: 10px;}

        * {
      font-family: "DejaVu Sans Mono", monospace;
    }
	</style>
</head>
<body style="margin: 0">
    <div class="container">
        <table class="" border="1" style="width: 100%">
            <tr>
                <td width="1%" align="center"><img src="{!! asset('plnlogo.png') !!}" style="width: 54px" alt=""></td>
                <td width="10%" align="center">
                    <b>SISTEM MANAJEMEN TERPUSAT</b><br>
                    <b>PT PLN (PERSERO) UNIT INDUK WILAYAH NUSA TENGGARA BARAT</b><br>
                    Jl. Langko No. 25 – 27 Ampenan, Mataram, Nusa Tenggara Barat 83114 <br>
                    Telp. : (0370) 643123 Fax. : (0370) 634401
                </td>
            </tr>
        </table>
        <table border="1" style="width: 100%">
            <tr>
                <td align="center">Level Dokumen : <br>IV</td>
                <td align="center">No. Dokumen <br>FM-K3-04-02</td>
                <td align="center">Tanggal : <br>15 Juli 2019</td>
                <td align="center">Edisi / Revisi :<br>
                    1 / 0</td>
                <td align="center">Halaman :<br>
                    1 - 1</td>
            </tr>
        </table>
        <br>

        <p style="text-align: center"><b><u>JOB SAFETY ANALYSIS</u></b><br><b style="font-size: 14px;">ANALISIS KESELAMATAN KERJA</b></p>
        {{-- <br> --}}
        <table border="1" style="width: 100%">
            <tr>
                <td width="20%" colspan="3"><b>A. INFORMASI PEKERJAAN</b></td>
            </tr>
            <tr>
                <td width="10%">Tanggal Pekerjaan</td>
                <td colspan="2" width="10%">: {{ date('d-m-Y', strtotime($jsa->workPermit->tgl_pengajuan)) }}</td>
            </tr>
            <tr>
                <td width="10%">Jenis Pekerjaan</td>
                <td colspan="2" width="10%">: {{ $jsa->workPermit->jenis_pekerjaan }}</td>
            </tr>
            <tr>
                <td width="10%">Detail Pekerjaan</td>
                <td colspan="2" width="10%">: {{ $jsa->workPermit->detail_pekerjaan }}</td>
            </tr>
            <tr>
                <td width="10%">Lokasi Pekerjaan</td>
                <td colspan="2" width="10%">: {{ $jsa->workPermit->lokasi_pekerjaan }}</td>
            </tr>
            <tr>
                <td width="10%">Perusahaan Pelaksana Pekerjaan</td>
                <td colspan="2" width="10%">: {{ $jsa->workPermit->users->name }}</td>
            </tr>
            <tr>
                <td width="10%">Pelaksana Pekerjaan</td>
                <td width="10%">NAMA</td>
                <td width="10%">TANDA TANGAN</td>
            </tr>

            {{-- @php
                $no = 1;
                $pl = '';
                $ttd = '';
                foreach ($jsa->jsaPegawai as $jp){
                    $pl = $pl.$no.'. '.$jp->pegawai->nama."<br>";
                    $no ++;
                }
            @endphp --}}

            
            @foreach($jsa->jsaPegawai as $jp)
            <tr>
                <td width="10%"></td>
                <td width="10%">{!! $jp->pegawai->nama !!}</td>
                <td width="5%" align="center">
                    @php
                    $qrcode = base64_encode(QrCode::size(40)->generate('Approved by Digital'));
                    @endphp
                    <br>
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    <br>
                </td>
            </tr>
            @endforeach
        </table>

        <table border="1" style="width: 100%">
            <tr>
                <td width="20%" colspan="4"><b>B. PERALATAN KESELAMATAN</b></td>
            </tr>
            <tr>
                <td>1. ALAT PELINDUNG DIRI</td>
                <td>{{ $jsa->apd_helm == 'on' ? '[✓] Helm' : '[  ] Helm' }}</td>
                <td>{{ $jsa->apd_earmuff == 'on' ? '[✓] Earmuff' : '[  ] Earmuff' }}</td>
                <td>{{ $jsa->apd_pelampung == 'on' ? '[✓] Pelampung / Life Vest' : '[  ] Pelampung / Life Vest' }}</td>
            </tr>
            <tr>
                <td rowspan="3"></td>
                <td>{{ $jsa->apd_sepatu_safety == 'on' ? '[✓] Sepatu Safety' : '[  ] Sepatu Safety' }}</td>
                <td>{{ $jsa->apd_sarung_tangan_katun == 'on' ? '[✓] Sarung Tangan Katun' : '[  ] Sarung Tangan Katun' }}</td>
                <td>{{ $jsa->apd_tabung_pernafasan == 'on' ? '[✓] Tabung Pernafasan' : '[  ] Tabung Pernafasa' }}</td>
            </tr>
            <tr>
                <td>{{ $jsa->apd_kacamata == 'on' ? '[✓] Kacamata' : '[  ] Kacamata' }}</td>
                <td>{{ $jsa->apd_sarung_tangan_karet == 'on' ? '[✓] Sarung Tangan Karet' : '[  ] Sarung Tangan Karet' }}</td>
                <td>{{ $jsa->apd_full_body_harness == 'on' ? '[✓] Full Body Harness' : '[  ] Full Body Harness' }}</td>
            </tr>
            <tr>
                <td>{{ $jsa->apd_earplug == 'on' ? '[✓] Earplug' : '[  ] Earplug' }}</td>
                <td>{{ $jsa->apd_sarung_tangan_20kv == 'on' ? '[✓] Sarung Tangan 20 KV' : '[  ] Sarung Tangan 20 KV' }}</td>
                <td>{{ $jsa->apd_lain == 'on' ? '[✓] Lain-lain, sebutkan :<br>'.$jsa->apd_lain_v : '[  ] Lain-lain, sebutkan :' }}</td>
            </tr>

            <tr>
                <td colspan="2">2. PERLENGKAPAN KESELAMATAN & DARURAT</td>
                <td>{{ $jsa->pkd_pemadam_api == 'on' ? '[✓] Pemadam Api (APAR dll)' : '[  ] Pemadam Api (APAR dll)' }}</td>
                <td>{{ $jsa->pkd_lain == 'on' ? '[✓] Lain-lain, sebutkan :<br>'.$jsa->pkd_lain_v : '[  ] Lain-lain, sebutkan :' }}</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="4"></td>
                <td>{{ $jsa->pkd_rambu_keselamatan == 'on' ? '[✓] Rambu Keselamatan' : '[  ] Rambu Keselamatan' }}</td>
                <td>[  ] ……………………………..</td>
            </tr>
            <tr>
                <td>{{ $jsa->pkd_loto == 'on' ? '[✓] LOTO (lock out tag out)' : '[  ] LOTO (lock out tag out)' }}</td>
                <td>[  ] ……………………………..</td>
            </tr>
            <tr>
                <td>{{ $jsa->pkd_loto == 'on' ? '[✓] LOTO (lock out tag out)' : '[  ] LOTO (lock out tag out)' }}</td>
                <td>[  ] ……………………………..</td>
            </tr>
            <tr>
                <td>{{ $jsa->pkd_radio_komunikasi == 'on' ? '[✓] Radio Komunikasi' : '[  ] Radio Komunikasi' }}</td>
                <td>[  ] ……………………………..</td>
            </tr>
            
            
        </table>
        <table border="1" style="width: 100%">
            <tr>
                <td width="20%" colspan="4"><b>C. ANALISIS KESELAMATAN KERJA</b></td>
            </tr>
            <tr>
                <td>NO</td>
                <td>LANGKAH PEKERJAAN</td>
                <td>POTENSI BAHAYA DAN RESIKO</td>
                <td>TINDAKAN PENGENDALIAN</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>1</td>
                <td>{!! $jsa->lp1 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr1)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp1)."<br><b>APD :</b><br>".$jsa->tp1_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp1_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>2</td>
                <td>{!! $jsa->lp2 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr2)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp2)."<br><b>APD :</b><br>".$jsa->tp2_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp2_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>3</td>
                <td>{!! $jsa->lp3 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr3)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp3)."<br><b>APD :</b><br>".$jsa->tp3_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp3_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>4</td>
                <td>{!! $jsa->lp4 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr4)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp4)."<br><b>APD :</b><br>".$jsa->tp4_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp4_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>5</td>
                <td>{!! $jsa->lp5 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr5)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp5)."<br><b>APD :</b><br>".$jsa->tp5_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp5_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>6</td>
                <td>{!! $jsa->lp6 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr6)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp6)."<br><b>APD :</b><br>".$jsa->tp6_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp6_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>7</td>
                <td>{!! $jsa->lp7 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr7)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp7)."<br><b>APD :</b><br>".$jsa->tp7_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp7_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>8</td>
                <td>{!! $jsa->lp8 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr8)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp8)."<br><b>APD :</b><br>".$jsa->tp8_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp8_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>9</td>
                <td>{!! $jsa->lp9 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr9)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp9)."<br><b>APD :</b><br>".$jsa->tp9_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp9_rambu !!}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td>10</td>
                <td>{!! $jsa->lp10 !!}</td>
                <td>{!! str_replace("\n","<br>", $jsa->pbr10)  !!}</td>
                <td>{!! str_replace("\n","<br>",$jsa->tp10)."<br><b>APD :</b><br>".$jsa->tp10_apd
                    ."<br><b>PKD :</b><br>".$jsa->tp10_rambu !!}</td>
            </tr>
            
            
        </table>
        <br>
        <br>
        

        <table border="1" style="width: 100%; margin-top: 25px;">
            <tr style="text-align: center; font-style: bold;">
                <td>DISETUJUI OLEH<br/>MANAJER</td>
                <td>DIPERIKSA OLEH<br/>SUPERVISOR</td>
                <td>DIPERIKSA OLEH<br/>PEJABAT PELAKSANA K3</td>
                <td>DIAJUKAN OLEH<br/>PELAKSANA PEKERJAAN</td>
            </tr>
            <tr style="text-align: center">
                <td style="height: 70px;">
                    @if ($jsa->workPermit->wpApproval->man_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Manager'));
                    @endphp
                    {{-- <img src="data:image/png;base64, {!! QrCode::size(50)->generate('Approved by manager'); !!}"> --}}
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @if ($jsa->workPermit->wpApproval->spv_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Supervisor'));
                    @endphp
                    {{-- <img src="data:image/png;base64, {!! QrCode::size(70)->generate('Approved by Supervisor'); !!}"> --}}
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @if ($jsa->workPermit->wpApproval->ppk3_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Pejabat Pelaksana K3'));
                    @endphp
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Diajukan oleh '.$jsa->workPermit->users->name));
                    @endphp
                <br>
                <img src="data:image/png;base64, {!! $qrcode !!}">
                <br>
                </td>
            </tr>
        </table>
        
  
        
    </div>
    
</body>
</html>