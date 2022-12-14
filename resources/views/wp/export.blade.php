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
                <td width="1%" align="center">
                    <img src="{!!  asset('plnlogo.png') !!}" style="width: 54px" alt="">
                </td>
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
                <td align="center">No. Dokumen <br>FM-K3-04-01</td>
                <td align="center">Tanggal : <br>15 Juli 2019</td>
                <td align="center">Edisi / Revisi :<br>
                    1 / 0</td>
                <td align="center">Halaman :<br>
                    1 - 1</td>
            </tr>
        </table>
        <br>

        <p style="text-align: center"><b><u>WORKING PERMIT</u></b><br><b style="font-size: 14px;">IJIN KERJA</b></p>
        {{-- <br> --}}
        <table border="1" style="width: 100%">
            <tr>
                <td width="20%" colspan="4"><b>A. INFORMASI PEKERJAAN</b></td>
            </tr>
            <tr>
                <td width="10%">1. Tanggal Pengajuan</td>
                <td colspan="3" width="10%">: {{ date('d-m-Y', strtotime($wp->tgl_pengajuan)) }}</td>
            </tr>
            <tr>
                <td width="10%">2. Jenis Pekerjaan</td>
                <td width="17%">: {{ $wp->jenis_pekerjaan }}</td>
                <td width="5%">SPK NO. </td>
                <td width="10%">: {!! $wp->spp_no !!}</td>
            </tr>
            <tr>
                <td width="10%">3. Detail Pekerjaan</td>
                <td colspan="3" width="10%">: {{ $wp->detail_pekerjaan }}</td>
            </tr>
            <tr>
                <td width="10%">4. Lokasi Pekerjaan</td>
                <td colspan="3" width="10%">: {{ $wp->lokasi_pekerjaan }}</td>
            </tr>
            <tr>
                <td width="10%">5. Pengawas Pekerjaan</td>
                <td width="17%">: {!! $wp->workPermitPP->pegawai->nama !!}</td>
                <td width="5%">No.Telp </td>
                <td width="10%">: {!! $wp->workPermitPP->pegawai->no_wa !!}</td>
            </tr>
            <tr>
                <td width="10%">6. Pengawas K3</td>
                <td width="10%">: {!! $wp->workPermitPPK3->pegawai->nama !!}</td>
                <td width="5%">No.Telp </td>
                <td width="10%">: {!! $wp->workPermitPPK3->pegawai->no_wa !!}</td>
            </tr>
        </table>
        <table border="1" style="width: 100%">
            <tr><td colspan="5" width="20%"><b>B.DURASI KERJA</b></td></tr>
            <tr>
                <td width="7%" align="center" rowspan="2">Durasi Kerja</td>
                <td width="5%">Tgl. Mulai</td>
                <td width="7%">: {{ date('d-m-Y', strtotime($wp->tgl_mulai)) }}</td>
                <td width="4%">Jam Mulai</td>
                <td width="7%">: {{ $wp->jam_mulai }}</td>
            </tr>
            <tr>
                <td width="3%">Tgl. Selesai</td>
                <td width="6%">: {{ date('d-m-Y', strtotime($wp->tgl_selesai)) }}</td>
                <td width="3%">Jam Selesai</td>
                <td width="7%">: {{ $wp->jam_selesai }}</td>
            </tr>
        </table>
        <table border="1" style="width: 100%">
            <tr><td colspan="3" width="20%"><b>C. KLASIFIKASI PEKERJAAN</b></td></tr>
            <tr>
                <td>{!! ($wp->kp1 == 'on' ? "[✓] Pekerjaan Bertegangan Listrik" : '[     ] Pekerjaan Bertegangan Listrik') !!}</td>
                <td>{!! ($wp->kp5 == 'on' ? "[✓] Pekerjaan di Ketinggian" : '[     ] Pekerjaan di Ketinggian') !!}</td>
                <td>{!! ($wp->kp8 == 'on' ? "[✓] Pekerjaan Penanaman Tiang" : '[     ] Pekerjaan Penanaman Tiang') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->kp2 == 'on' ? "[✓] Pekerjaan Overhaul Mesin" : '[     ] Pekerjaan Overhaul Mesin') !!}</td>
                <td>{!! ($wp->kp6 == 'on' ? "[✓] Pekerjaan Penggalian" : '[     ] Pekerjaan Penggalian') !!}</td>
                <td>{!! ($wp->kp9 == 'on' ? "[✓] Pekerjaan Konstruksi" : '[     ] Pekerjaan Konstruksi') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->kp3 == 'on' ? "[✓] Pekerjaan Panas" : '[     ] Pekerjaan Panas') !!}</td>
                <td>{!! ($wp->kp7 == 'on' ? "[✓] Pekerjaan B3 & Limbah B3" : '[     ] Pekerjaan B3 & Limbah B3') !!}</td>
                <td>{!! ($wp->kp10 == 'on' ? "[✓] Pekerjaan Sipil" : '[     ] Pekerjaan Sipil') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->kp4 == 'on' ? "[✓] Pekerjaan Lainnya, <br>*$wp->kp4_lainnya" : '[     ] Pekerjaan Lainnya, sebutkan') !!}</td>
                <td></td>
                <td></td>
            </tr>
            <tr><td colspan="3" width="20%"><b>D. PROSEDUR PEKERJAAN YANG TELAH DIJELASKAN KEPADA PEKERJA</b></td></tr>
            <tr>
                <td>{!! ($wp->p1 == 'on' ? "[✓] Pemeliharaan Pembangkit" : '[     ] Pemeliharaan Pembangkit') !!}</td>
                <td>{!! ($wp->p5 == 'on' ? "[✓] Pemeliharaan Disribusi" : '[     ] Pemeliharaan Disribusi') !!}</td>
                <td>{!! ($wp->p8 == 'on' ? "[✓] Pemeliharaan Transmisi" : '[     ] Pemeliharaan Transmisi') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->p2 == 'on' ? "[✓] Pemeliharaan Kubikel" : '[     ] Pemeliharaan Kubikel') !!}</td>
                <td>{!! ($wp->p6 == 'on' ? "[✓] PDKB TM" : '[     ] PDKB TM') !!}</td>
                <td>{!! ($wp->p9 == 'on' ? "[✓] Pemeliharaan Gardu Induk" : '[     ] Pemeliharaan Gardu Induk') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->p3 == 'on' ? "[✓] Pemeliharaan APP Pelanggan" : '[     ] Pemeliharaan APP Pelanggan') !!}</td>
                <td>{!! ($wp->p7 == 'on' ? "[✓] Pengoperasian Jaringan Baru" : '[     ] Pengoperasian Jaringan Baru') !!}</td>
                <td>{!! ($wp->p10 == 'on' ? "[✓] Bongkar Pasang Tiang Beton" : '[     ] Bongkar Pasang Tiang Beton') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->p4 == 'on' ? "[✓] Prosedur Lainnya, <br>* $wp->p4_lainnya" : '[     ] Prosedur Lainnya, sebutkan') !!}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table border="1" style="width: 100%">
            <tr><td colspan="2" width="20%"><b>E. LAMPIRAN IZIN KERJA (WAJIB DILAMPIRKAN)</b></td></tr>
            <tr>
                <td width="10%">{!! ($wp->workPermitHirarc != null ? "[✓]  Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (IBPPR)" : '[     ]  Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (IBPPR)') !!}</td></td>
                <td width="10%">{!! ($wp->jsa != null ? "[✓]  Job Safety Analysis (JSA)" : '[     ]  Job Safety Analysis (JSA)') !!}</td>
            </tr>
            <tr>
                <td>{!! ($wp->workPermitProsedurKerja != null ? "[✓]  Prosedur Kerja" : '[     ]  Prosedur Kerja') !!}</td>
                <td>{!! ($wp->jsa != null ? "[✓]  Sertifikasi Kompetensi Pekerja" : '[     ]  Sertifikasi Kompetensi Pekerja') !!}</td>
            </tr>
        </table>
        <table border="1" style="width: 100%">
            <tr><td colspan="2" width="20%" style="height: 24px;">Keterangan : Form Izin Kerja tidak dapat disetujui jika salah satu lampiran tidak ada</tr>
        </table>
        <br>

        <table border="1" style="width: 100%">
            <tr style="text-align: center; font-style: bold;">
                <td>DISETUJUI OLEH<br/>MANAJER</td>
                <td>DIPERIKSA OLEH<br/>SUPERVISOR</td>
                <td>DIPERIKSA OLEH<br/>PEJABAT PELAKSANA K3</td>
                <td>DIAJUKAN OLEH<br/>PELAKSANA PEKERJAAN</td>
            </tr>
            <tr style="text-align: center">
                <td style="height: 70px;">
                    @if ($wp->wpApproval->man_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Manager'));
                    @endphp
                    {{-- <img src="data:image/png;base64, {!! QrCode::size(50)->generate('Approved by manager'); !!}"> --}}
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @if ($wp->wpApproval->spv_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Supervisor'));
                    @endphp
                    {{-- <img src="data:image/png;base64, {!! QrCode::size(70)->generate('Approved by Supervisor'); !!}"> --}}
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @if ($wp->wpApproval->ppk3_app != NULL)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Pejabat Pelaksana K3'));
                    @endphp
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
                <td>
                    @if ($wp->submit == 1)
                    @php
                    $qrcode = base64_encode(QrCode::size(70)->generate('Approved by Pejabat Pelaksana K3'));
                    @endphp
                    <img src="data:image/png;base64, {!! $qrcode !!}">
                    @endif
                </td>
            </tr>
        </table>
        
  
        
    </div>
    
</body>
</html>