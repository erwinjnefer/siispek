@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{!! asset('/admin/bower_components/select2/dist/css/select2.min.css') !!}">
{{-- <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-timepicker/css/timepicker.less') }}"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-timepicker@0.5.2/css/bootstrap-timepicker.min.css"rel="stylesheet"> --}}

@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Work Permit
        <small>Form Inspekta</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('work-permit') !!}"><i class="fa fa-book"></i> Work Permit</a></li>
        <li class="active">Form Inspekta</li>
    </ol>
</section>

@endsection
@section('content')
<div class="row">

    

    {{-- Sertifikat --}}
    <div class="modal fade" id="view-sertifikat-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Pilih Sertifikat</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <select class="form-control" id="sertifikat_select_jp">
                            <option value=""></option>
                            <option>Administrasi</option>
                            <option>Pendirian Tiang</option>
                            <option>Penarikan Kabel</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Pilih FIle Sertifikat</label>
                                <select class="form-control" id="sertifikat_file_select"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Upload Sertifikat</label>
                                <button id="btn-upload-sertifikat" class="form-control btn-primary"> Upload</button>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <iframe width="100%" height="1000px" id="sertifikat_iframe" frameborder="0"></iframe>
                    </div>
                    
                    
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left btn-sertifikat-ok">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-sertifikat-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_sertifikat_add" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Upload Sertifikat</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Jenis Pekerjaan</label>
                            <select class="form-control" name="jenis_pekerjaan">
                                <option>Administrasi</option>
                                <option>Pendirian Tiang</option>
                                <option>Penarikan Kabel</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <input type="text" class="form-control" name="ket">
                        </div>
                        
                        <div class="form-group">
                            <label for="">File</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="form_wp" method="post">
        @csrf

        <input type="hidden" name="work_order_id" value="{{ $wo->id }}">

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h4>A. INFORMASI PEKERJAAN</h4>
                </div>
                <div class="box-body">
                    
                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Unit</label>
                                <select class="form-control" placeholder="" name="unit_id" id="unit_select">
                                    <option value=""></option>
                                    @foreach ($unit as $unit)
                                    <option value="{{ $unit->id }}" {{ $wo->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Level Bagian</label>
                                <select class="form-control" required name="bidang">
                                    <option>Keuangan dan Umum</option>
                                    <option>Konstruksi</option>
                                    <option>Jaringan</option>
                                    <option>Pemasaran dan Pelayanan Pelanggan</option>
                                    <option>Transaksi Energi ULP</option>
                                    <option>Perencanaan</option>
                                    <option>Teknik</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="">Tgl. Pengajuan</label>
                        <input type="text" class="form-control" readonly value="{{ date('Y-m-d') }}" autocomplete="off" placeholder="" name="tgl_pengajuan">
                    </div>

                    <div class="form-group">
                        <label for="">SPK NO.</label>
                        <input type="text" class="form-control" placeholder="" required name="spp_no" value="{{ $wo->spk_no }}">
                    </div>

                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <select class="form-control" name="jenis_pekerjaan">
                            <option value=""></option>
                            <option>Jaringan</option>
                            <option>PDKB</option>
                            <option>Konstruksi</option>
                            <option>Transaksi Energi ULP</option>
                            <option>K3L</option>
                            <option>Umum</option>
                        </select>
                    </div>

                    
                    
                    
                    <div class="form-group">
                        <label for="">Detail Pekerjaan</label>
                        <textarea class="form-control" placeholder="" name="detail_pekerjaan" rows="3">{{ $wo->nama }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" name="lokasi_pekerjaan">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
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
                                    <option value="{!! $pp->id !!}">{!! $pp->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="">No. Telp</label>
                                <input type="text" class="form-control" placeholder="" name="no_telp_pengawas">
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group p_k3" data-html="true" data-content="1. Memeriksa kondisi personil sebelum bekerja<br />
                            2. Mengawasi kondisi/tempat-tempat yang berbahaya<br />
                            3. Mengawasi pemasangan dan pelepasan tagging, gembok dan rambu pengaman<br />
                            4. Mengawasi tingkah laku/sikap personil yang membahayakan diri sendiri atau orang lain<br />
                            5. Mengawasi penggunaan perlengkapan keselamatan kerja" rel="popover" data-placement="top" data-original-title="Tugas" data-trigger="hover">
                                <label for="">Pengawas K3</label>
                                <select type="text" class="form-control" placeholder="" name="pp_k3_id">
                                    <option value="">Pilih ...</option>
                                    @foreach ($pk3 as $pp_k3)
                                    <option value="{!! $pp_k3->id !!}">{!! $pp_k3->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pel_pek">
                                <label for="">Pelaksana Pekerjaan</label>
                                <select class="form-control select2" placeholder="" name="pel_pek_id[]" multiple>
                                    <option value="">Pilih ...</option>
                                    @foreach ($pel as $item)
                                    <option value="{!! $item->id !!}">{!! $item->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group p_manuver" data-html="true" data-content="1. Mengawasi pelaksana manuver<br />
                    2. Mengawasi pemasangan dan pelepasan tagging di panel control serta rambu pengaman/gembok di switch yard<br />
                    3. Mengawasi pemasangan dan pelepasan system pentanahan<br />
                    4. Menjelaskan bersama Pengawas K3 kepada Pengawas Pekerjaan dan Pelaksana Pekerjaan tentang daerah aman dan tidak aman untuk dikerjakan" rel="popover" data-placement="top" data-original-title="Tugas" data-trigger="hover">
                        <label for="">Pengawas Internal / Manuver</label>
                        <select type="text" class="form-control" placeholder="" name="pengawas_manuver_id" id="pengawas_manuver">
                            {{-- <option value="">Pilih ...</option> --}}
                            {{-- @foreach ($pengawas_manuver as $p_manuver)
                            <option value="{!! $p_manuver->id !!}">{!! $p_manuver->name !!}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>

            
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h4>B. DURASI KERJA</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Mulai</label>
                                <input type="text" class="form-control" autocomplete="off" id="tgl_mulai" placeholder="" name="tgl_mulai" value="{{ date('d-m-Y', strtotime($wo->tgl_mulai)) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Mulai</label>
                                <input type="text" class="form-control" placeholder="" id="jam_mulai" name="jam_mulai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Selesai</label>
                                <input type="text" class="form-control" autocomplete="off" id="tgl_selesai" placeholder="" name="tgl_selesai" value="{{ date('d-m-Y', strtotime($wo->tgl_selesai)) }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Jam Selesai</label>
                                <input type="text" class="form-control" placeholder="" id="jam_selesai" name="jam_selesai">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Tgl. Rencana Pelaksanaan Pekerjaan</label>
                        <input type="text" class="form-control" autocomplete="off" id="tgl_rencana_pelaksanaan" placeholder="" name="tgl_rencana_pelaksanaan" required>
                    </div>
                </div>

                
            </div>

            <div class="box">
                <div class="box-header with-border">
                    <h4>C. FORM WORKING PERMIT INSPEKTA</h4>
                </div>
                <div class="box-body">

                    <div class="callout callout-success">
                        <h4>URL Inspekta</h4>
                        <p><a href="#" class="form_link">Open Link</a></p>
                    </div>

                    <div class="form-group">
                        <label for="">Link Detail Work Permit Inspekta</label>
                        <input type="text" class="form-control" placeholder="" name="url">
                    </div>

                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-success" id="btn-save">SIMPAN</button>
                </div>
            </div>
        </div>
        
        
        
        
        
    </form>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{!! asset('admin/bower_components/select2/dist/js/select2.full.min.js') !!}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="{{ asset('admin/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script type="text/javascript">
    var jsa_file_id = 0
    var kp4_lain = ''
    var p4_lain = ''

    $('.select2').select2()

    $('.p_manuver, .p_k3, .p_pk').popover();
    // $('.p_k3').popover();

    loadManuver("{{ $wo->unit_id }}")

    $(document).on('click','.form_link', function(){
        let params = `scrollbars=yes,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=1000,left=100,top=100`;
        open("https://hsse.pln.co.id/working_permits/create", 'Inspekta', params);
        
    })

    $(document).on('change','#unit_select', function(){
        var uid = $('#unit_select').val()

        loadManuver(uid);
        
    })

    function loadManuver(uid){
        if(uid != ''){
            $.ajax({
                type : 'get',
                url : "{{ url('work-permit/manuver-select?id=') }}"+uid,
                success : function(r){
                    console.log(r)
                    $('#pengawas_manuver').empty()
                    $.each(r, function(i, d){
                        $('#pengawas_manuver').append('<option value="'+d.id+'">'+d.name+'</option>')
                    })
                }
            })
        }else{
            $('#pengawas_manuver').empty()
        }
    }



    $('#datepicker,#tgl_mulai,#tgl_selesai,#tgl_rencana_pelaksanaan').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    })

    $('#jam_mulai,#jam_selesai').timepicker({
      showInputs: false,
      use24hours: true,
      format: 'HH:mm',
      showMeridian: false
    })

    // HIRARC
    $(document).on('click','.btn-hirarc-ok', function(){
        $('#view-hirarc-modal').modal('hide')
    })

    $(document).on('click','#btn-upload-hirarc', function(){
        $('#add-hirarc-modal').modal('show')
        // $('#add_jenis_pekerjaan').val($('#select_jp').val())
    })

    

    $("#kp4").change(function() {
        if(this.checked) {
            $('#kp4_lainnya').attr('readonly', false);
            $('#kp4_lainnya').focus()
        }else{
            $('#kp4_lainnya').attr('readonly', true);
            $('#kp4_lainnya').val('')
        }
    });

    $("#p4").change(function() {
        if(this.checked) {
            $('#p4_lainnya').attr('readonly', false);
            $('#p4_lainnya').focus()
        }else{
            $('#p4_lainnya').attr('readonly', true);
            $('#p4_lainnya').val('')
        }
    });

    
    


    

    // Sertifikat
    $(document).on('click','.btn-sertifikat-ok', function(){
        $('#view-sertifikat-modal').modal('hide')
    })

    $(document).on('click','#btn-upload-sertifikat', function(){
        $('#add-sertifikat-modal').modal('show')
        // $('#add_jenis_pekerjaan').val($('#select_jp').val())
    })

    $('#form_sertifikat_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('sertifikat/create') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                if (r == 'success') {
                    Swal.fire(
                    'Yeaa !',
                    'Simpan data berhasil !',
                    'success'
                    )
                    $('#add-sertifikat-modal').modal('hide')
                    loadJsaFile($('#sertifikat_select_jp').val())
                }
            }
        })
    })
    
    $("#l4").change(function() {
        if(this.checked) {
            $('#view-sertifikat-modal').modal('show')
        }
    });
    
    $(document).on('change','#sertifikat_select_jp', function(){
        loadSertifikatFile($('#sertifikat_select_jp').val())
    })
    
    $(document).on('change','#sertifikat_file_select', function(){
        var id = $('#sertifikat_file_select').val()
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('sertifikat/get-by-id?id=') }}"+id,
            success : function(r){
                hidePleaseWait()
                $('#sertifikat_id').val(r.id)
                var link = "{!! url('') !!}/"+r.file
                console.log(link)
                document.getElementById("sertifikat_iframe").src=link;
            }
        })
    })
    
    function loadSertifikatFile(jenis_pekerjaan){
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('sertifikat/get-by-jp?jp=') }}"+jenis_pekerjaan,
            success : function(r){
                console.log(r)
                hidePleaseWait()
                $('#sertifikat_file_select').empty()
                $('#sertifikat_file_select').append('<option value=""></option>')
                $.each(r.sertifikat, function(i, d){
                    $('#sertifikat_file_select').append(
                    '<option value="'+d.id+'">'+'('+d.ket+') '+d.file+'</option>'
                    )
                })
            }
        })
    }
    
    $(document).on('click','#btn-save', function(){
        $('#form_wp').submit()
        // if($('#l1').is(':checked') && $('#l2').is(':checked') && $('#l3').is(':checked') && $('#l4').is(':checked')){
        // }else{
            
        //     Swal.fire(
        //     'Ops !',
        //     'Lampiran tidak lengkap !',
        //     'error'
        //     )
            
        // }
        
    })
    
    $('#form_wp').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('work-permit/create-inspekta') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                hidePleaseWait()
                if (r == 'success') {
                    Swal.fire(
                    'Yeaa !',
                    'Simpan data berhasil !',
                    'success'
                    ).then(function(){
                        window.location = "{{ url('work-permit') }}"
                    })
                }
            }
        })
    })
</script>

@endsection