<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inpseksi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}

        @page { margin-left: 0px; margin-right: 0px;margin-top: 24px; margin-bottom: 10px; }
        body { margin-left: 0px; margin-right: 0px;margin-top: 5px; margin-bottom: 10px;}
	</style>
</head>
<body style="margin-left: 5px; margin-right: 5px;">
    <table border="1" style="width: 100%">
        <tr>
            <td width="4%"><img src="http://localhost/wp/plnlogo.png" style="width: 74px" alt=""></td>
            <td width="10%" colspan="4"><b>SISTEM MANAJEMEN TERPUSAT <br>PT PLN (PERSERO) UNIT INDUK WILAYAH NUSA TENGGARA BARAT Jl. Langko No. 25 – 27 <br>
                Ampenan, Mataram, Nusa Tenggara Barat 83114 <br>
                Telp. : (0370) 643123 Fax. : (0370) 634401 </b></td>
        </tr>
        <tr>
            <td align="center">Level Dokumen : IV</td>
            <td align="center">No. Dokumen : FM-K3-09</td>
            <td align="center">Tanggal : </td>
            <td align="center">Edisi / Revisi :
                1 / 0</td>
            <td align="center">Halaman :
                1 - 1</td>

        </tr>

    </table>
    <br>
    <b style="font-size: 14px;">FORMULIR INSPEKSI K3 PEKERJAAN</b>
    <table border="1" style="width: 100%">
        <tr style="background: dodgerblue">
            <td width="1%" align="center">I</td>
            <td width="7%">INFORMASI PEKERJAAN</td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="1%" align="center">a</td>
            <td width="7%">Tanggal Pekerjaan</td>
            <td width="15%">: {!! date('d-m-Y', strtotime($inspeksiLanjut->date)) !!}</td>
        </tr>
        <tr>
            <td width="1%" align="center">b</td>
            <td width="7%">Fungsi Pekerjaan</td>
            <td width="15%">: {!! $wp->jenis_pekerjaan !!}</td>
        </tr>
        <tr>
            <td width="1%" align="center">c</td>
            <td width="7%">Nama Pekerjaan</td>
            <td width="15%">: {!! $wp->detail_pekerjaan !!}</td>
        </tr>
        <tr>
            <td width="1%" align="center">d</td>
            <td width="7%">Lokasi Pekerjaan</td>
            <td width="15%">: {!! $inspeksiLanjut->lokasi.' '.$inspeksiLanjut->koordinat !!}</td>
        </tr>
        <tr>
            <td width="1%" align="center">e</td>
            <td width="7%">Unit Kerja PLN</td>
            <td width="15%">: {!! $wp->unit->nama !!}</td>
        </tr>
        <tr>
            <td width="1%" align="center">f</td>
            <td width="7%">Perusahaan Pelaksana</td>
            <td width="15%">: {!! $wp->users->name !!}</td>
        </tr>

        <tr style="background: dodgerblue">
            <td width="1%" align="center">II</td>
            <td width="7%">INFORMASI PERSONIL</td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="1%" align="center">a</td>
            <td width="7%">Nama Pengawas Pekerjaan</td>
            <td width="15%">: {{ $wp->workPermitPP->pegawai->nama }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">b</td>
            <td width="7%">Nama Pengawas K3 Pekerjaan</td>
            <td width="15%">: {{ $wp->workPermitPPK3->pegawai->nama }}</td>
        </tr>
        @php
                $pelaksana = "";
                $c = 1;
                foreach ($wp->jsa->jsaPegawai as $jp) {
                    $pelaksana = $pelaksana.$c++ .'. '.$jp->pegawai->nama."<br>";
                }
        @endphp

        <tr>
            <td width="1%" align="center">c</td>
            <td width="7%">Nama Pelaksana Pekerjaan</td>
            <td width="15%">{!! $pelaksana !!}</td>
        </tr>



        <tr style="background: dodgerblue">
            <td width="1%" align="center">III</td>
            <td width="7%">INFORMASI K3</td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="1%" align="center">a</td>
            <td width="7%">Kondisi Pelaksanan Pekerjaan</td>
            <td width="15%">: {{ $inspeksiLanjut->kondisi_pelaksana_pekerjaan }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">b</td>
            <td width="7%">Penggunaan APD</td>
            <td width="15%">: {{ $inspeksiLanjut->penggunaan_apd }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">c</td>
            <td width="7%">Penggunaan Perlengkapan Kerja</td>
            <td width="15%">: {{ $inspeksiLanjut->penggunaan_perlengkapan_kerja }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">d</td>
            <td width="7%">Pemasangan Rambu K3</td>
            <td width="15%">: {{ $inspeksiLanjut->pemasangan_rambu_k3 }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">e</td>
            <td width="7%">Pemasangan LOTO</td>
            <td width="15%">: {{ $inspeksiLanjut->pemasangan_loto }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">f</td>
            <td width="7%">Pemasangan Pembumian</td>
            <td width="15%">: {{ $inspeksiLanjut->pemasangan_pembumian }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">g</td>
            <td width="7%">Pembebasan/Pemeriksaan Tegangan</td>
            <td width="15%">: {{ $inspeksiLanjut->pembebasasn_pemeriksaan_tegangan }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">h</td>
            <td width="7%">Pelaksanaan Briefing K3 di Lokasi</td>
            <td width="15%">: {{ $inspeksiLanjut->pelaksanaan_breafing }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">i</td>
            <td width="7%">JSA</td>
            <td width="15%">: {{ $inspeksiLanjut->jsa }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">j</td>
            <td width="7%">SOP</td>
            <td width="15%">: {{ $inspeksiLanjut->sop }}</td>
        </tr>
        <tr>
            <td width="1%" align="center">k</td>
            <td width="7%">Working Permit</td>
            <td width="15%">: {{ $inspeksiLanjut->wp }}</td>
        </tr>
        <tr style="background: dodgerblue">
            <td width="1%" align="center"><b>IV</b></td>
            <td width="7%" colspan="2"><b>CATATAN TEMUAN YANG PERLU DILAPORKAN :</b></td>
        </tr>
        <tr>
            <td style="height: 40px;" colspan="3">{!! $inspeksiLanjut->catatan_temuan !!}</td>
        </tr>
        <tr style="background: dodgerblue">
            <td width="1%" align="center"><b>V</b></td>
            <td width="7%" colspan="2"><b>DOKUMENTASI FOTO :</b></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br>
                <br>
                @foreach ($inspeksiLanjut->inspeksiFoto as $foto)
                <img src="{!! url($foto->foto) !!}" style="width: 300px;height: 200px;" alt="Attachment">
                @endforeach
            </td>
        </tr>
        <tr style="background: dodgerblue">
            <td width="1%" align="center"><b>VI</b></td>
            <td width="7%" colspan="2"><b>SARAN / REKOMENDASI PERBAIKAN :</b></td>
        </tr>
        <tr>
            <td style="height: 40px;" colspan="3">{!! $inspeksiLanjut->saran_rekomendasi !!}</td>
        </tr>
        <tr style="background: dodgerblue">
            <td width="1%" align="center"><b>VII</b></td>
            <td width="7%" colspan="2"><b>TINDAKAN SELANJUTNYA</b></td>
        </tr>
        <tr>
            <td style="height: 40px;" colspan="3">{!! $inspeksiLanjut->tindakan_selanjutnya !!}</td>
        </tr>

        <tr style="background: dodgerblue">
            <td width="2%" align="center"><b>VIII</b></td>
            <td width="7%" colspan="2"><b>INFORMASI INSPEKSI :</b></td>
        </tr>
        
    </table>
    <table border="1" style="width: 100%">
        <tr>
            <td align="center">K3 PLN</td>
            <td align="center">K3 Vendor</td>
            <td align="center">Diinspeksi Oleh</td>
        </tr>
        <tr>
         
            <td width="5%" align="center">
                @if ($inspeksiLanjut->app_k3_pln != null)
                @php
                    $qrcode = base64_encode(QrCode::size(40)->generate('Approved by '.$inspeksiLanjut->app_k3_pln));
                @endphp
                <br>
                <img src="data:image/png;base64, {!! $qrcode !!}">
                @else
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @endif
                <br>
            </td>
            <td width="5%" align="center">
                @if ($inspeksiLanjut->app_k3_vendor != null)
                @php
                    $qrcode = base64_encode(QrCode::size(50)->generate('Approved by '.$inspeksiLanjut->app_k3_vendor));
                @endphp
                <br>
                <img src="data:image/png;base64, {!! $qrcode !!}">
                @else
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @endif
                <br>
            </td>
            <td width="5%" align="center">
                @if ($inspeksiLanjut != null)
                @php
                    $qrcode = base64_encode(QrCode::size(50)->generate('Diinspeksi by '.$inspeksiLanjut->nama_inspektor));
                @endphp
                <br>
                <img src="data:image/png;base64, {!! $qrcode !!}">
                @else
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @endif
                <br>
            </td>
        </tr>

        {{-- <tr>
            <td width="5%" align="center">{!! $inspeksiLanjut->app_k3_pln !!}</td>
            <td width="5%" align="center">{{ $inspeksiLanjut->app_k3_vendor }}</td>
            <td width="5%" align="center">{{ $inspeksiLanjut->nama_inspektor }}</td>
        </tr> --}}
        
    </table>
    
</body>
</html>
