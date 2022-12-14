@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Work Permit
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('work-permit') !!}"><i class="fa fa-book"></i> Work Permit</a></li>
        <li class="active">Edit</li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
    <form id="form_wp_edit">
        @csrf
        <input type="hidden" name="id" value="{{ $wp->id }}">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h4>A. INFORMASI PEKERJAAN</h4>
                </div>
                <div class="box-body">

                    <div class="form-group">
                        <label for="">Tgl. Pengajuan</label>
                        <input type="text" class="form-control"  id="datepicker" autocomplete="off" name="tgl_pengajuan"
                            value="{{ date('d-m-Y', strtotime($wp->tgl_pengajuan)) }}">
                    </div>

                    <div class="form-group">
                        <label for="">SPK NO.</label>
                        <input type="text" class="form-control" placeholder="" name="spp_no" value="{{ $wp->spp_no }}">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" name="jenis_pekerjaan"
                            value="{{ $wp->jenis_pekerjaan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Detail Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" name="detail_pekerjaan"
                            value="{{ $wp->detail_pekerjaan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" name="lokasi_pekerjaan"
                            value="{{ $wp->lokasi_pekerjaan }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group p_pk" data-html="true" data-content="1. Memimpin koordinasi rencana pelaksanaan maneuver dengan Pengawas K3 dan Pengawas maneuver<br />
                            2. Memimpin Briefing rencana pelaksanaan pekerjaan dan pembagian tugas Pengawas K3 yang ditutup dengan doa bersama<br />
                            3. Mengawasi Pemasangan dan Pelepasan Pentanahan local<br />
                            4. Mengawasi Pemasangan dan Pelepasan tagging, gembok dan rambu pengamanan<br />
                            5. Menjelaskan metode pekerjaan<br />
                            6. Menunjuk personil pelaksana pekerjaan sebagai pelaksana, pengaman instalasi Gardu Induk Listrik untuk memasang dan melepas tagging, gembok dan rambu pengaman di Switch yard<br />
                            7. Memimpin evaluasi pelaksanaan pekerjaan dan melaksanakan doa penutup" rel="popover" data-placement="top" data-original-title="Tugas" data-trigger="hover">
                                <label for="">Pengawas Pekerjaan</label>
                                <select type="text" class="form-control" required placeholder="" name="pp_id">
                                    <option value="">Pilih ...</option>
                                    @foreach ($pp as $pp)
                                    <option value="{!! $pp->id !!}" {{ $pp->id == $wp->workPermitPP->pegawai_id ? 'selected' : '' }}>{!! $pp->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">No. Telp</label>
                                <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPP->pegawai->no_wa !!}">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group p_k3" data-html="true" data-content="1. Memeriksa kondisi personil sebelum bekerja<br />
                            2. Mengawasi kondisi/tempat-tempat yang berbahaya<br />
                            3. Mengawasi pemasangan dan pelepasan tagging, gembok dan rambu pengaman<br />
                            4. Mengawasi tingkah laku/sikap personil yang membahayakan diri sendiri atau orang lain<br />
                            5. Mengawasi penggunaan perlengkapan keselamatan kerja" rel="popover" data-placement="top" data-original-title="Tugas" data-trigger="hover">
                                <label for="">Pengawas K3</label>
                                <select type="text" class="form-control" placeholder="" name="pp_k3_id">
                                    <option value="">Pilih ...</option>
                                    @foreach ($pk3 as $pp_k3)
                                    <option value="{!! $pp_k3->id !!}" {{ $pp_k3->id == $wp->workPermitPPK3->pegawai_id ? 'selected' : '' }}>{!! $pp_k3->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">No. Telp</label>
                                <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPPK3->pegawai->no_wa !!}">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group p_manuver" data-html="true" data-content="1. Mengawasi pelaksana manuver<br />
                            2. Mengawasi pemasangan dan pelepasan tagging di panel control serta rambu pengaman/gembok di switch yard<br />
                            3. Mengawasi pemasangan dan pelepasan system pentanahan<br />
                            4. Menjelaskan bersama Pengawas K3 kepada Pengawas Pekerjaan dan Pelaksana Pekerjaan tentang daerah aman dan tidak aman untuk dikerjakan" rel="popover" data-placement="top" data-original-title="Tugas" data-trigger="hover">
                                <label for="">Pengawas Internal / Manuver</label>
                                <select type="text" class="form-control" placeholder="" name="pengawas_manuver_id" id="pengawas_manuver">
                                    <option value="">Pilih ...</option>
                                    @foreach ($pengawas_manuver as $p_manuver)
                                    <option value="{!! $p_manuver->id !!}" {{ $p_manuver->id == $wp->pengawasManuver->users_id ? 'selected' : '' }}>{!! $p_manuver->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">No. Telp</label>
                                <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->pengawasManuver->users->no_wa !!}">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>


            <div class="box">
                <div class="box-header">
                    <h4>B. DURASI KERJA</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Mulai</label>
                                <input type="text" class="form-control" placeholder="" autocomplete="off" id="tgl_mulai" name="tgl_mulai"
                                value="{{ date('d-m-Y', strtotime($wp->tgl_mulai)) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Mulai</label>
                                <input type="text" class="form-control" placeholder="" name="jam_mulai"
                                    value="{{ $wp->jam_mulai }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Selesai</label>
                                <input type="text" class="form-control" placeholder="" autocomplete="off" id="tgl_selesai" name="tgl_selesai"
                                value="{{ date('d-m-Y', strtotime($wp->tgl_selesai)) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Selesai</label>
                                <input type="text" class="form-control" placeholder="" name="jam_selesai"
                                    value="{{ $wp->jam_selesai }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>C. KLASIFIKASI PEKERJAAN</h4>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp1"
                                        {{ $wp->kp1 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Bertegangan Listrik
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp2"
                                        {{ $wp->kp2 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Overhaul Mesin
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp3"
                                        {{ $wp->kp3 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Panas
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp4" id="kp4"
                                        {{ $wp->kp4 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Lainnya, sebutkan
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="kp4_lainnya" name="kp4_lainnya"
                                        class="form-control" value="{{ $wp->kp4 == 'on' ? $wp->kp4_lainnya : '' }}" {{ $wp->kp4 == 'on' ? '' : 'readonly' }}>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp5"
                                        {{ $wp->kp5 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan di Ketinggian
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp6"
                                        {{ $wp->kp6 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Penggalian
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp7"
                                        {{ $wp->kp7 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan B3 & Limbah B3
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp8"
                                        {{ $wp->kp8 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Penanaman Tiang
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp9"
                                        {{ $wp->kp9 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Konstruksi
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="kp10"
                                        {{ $wp->kp10 == 'on' ? 'checked' : '' }}>
                                    Pekerjaan Sipil
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>D. PROSEDUR PEKERJAAN YANG TELAH DIJELASKAN KEPADA PEKERJA</h4>
                </div>
                <div class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p1"
                                        {{ $wp->p1 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan Pembangkit
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p2"
                                        {{ $wp->p2 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan Kubikel
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p3"
                                        {{ $wp->p3 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan APP Pelanggan
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p4" id="p4"
                                        {{ $wp->p4 == 'on' ? 'checked' : '' }}>
                                    Prosedur Lainnya, sebutkan
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" id="p4_lainnya" name="p4_lainnya"
                                        class="form-control" value="{{ $wp->p4 == 'on' ? $wp->p4_lainnya : '' }}" {{ $wp->p4 == 'on' ? '' : 'readonly' }}>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p5"
                                        {{ $wp->p5 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan Disribusi
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p6"
                                        {{ $wp->p6 == 'on' ? 'checked' : '' }}>
                                    PDKB TM
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p7"
                                        {{ $wp->p7 == 'on' ? 'checked' : '' }}>
                                    Pengoperasian Jaringan Baru
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p8"
                                        {{ $wp->p8 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan Transmisi
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p9"
                                        {{ $wp->p9 == 'on' ? 'checked' : '' }}>
                                    Pemeliharaan Gardu Induk
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="p10"
                                        {{ $wp->p10 == 'on' ? 'checked' : '' }}>
                                    Bongkar Pasang Tiang Beton
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-success btn-save"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('js')
<script src="{{ asset('admin/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('click', '.btn-save', function () {
        $('#form_wp_edit').submit()
    })

    $('#datepicker,#tgl_mulai,#tgl_selesai').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    })

    $("#kp4").change(function () {
        if (this.checked) {
            $('#kp4_lainnya').attr('readonly', false);
            $('#kp4_lainnya').focus()
        } else {
            $('#kp4_lainnya').attr('readonly', true);
            $('#kp4_lainnya').val('')
        }
    });

    $("#p4").change(function () {
        if (this.checked) {
            $('#p4_lainnya').attr('readonly', false);
            $('#p4_lainnya').focus()
        } else {
            $('#p4_lainnya').attr('readonly', true);
            $('#p4_lainnya').val('')
        }
    });





    $('#form_wp_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('work-permit/update') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                if (r == 'success') {
                    Swal.fire(
                        'Yeaa !',
                        'Simpan data berhasil !',
                        'success'
                    )
                    window.location =
                        "{{ url('work-permit/detail?id='.$wp->id) }}"
                }
            }
        })
    })

</script>

@endsection
