@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
<link rel="stylesheet" href="{!! asset('/admin/bower_components/select2/dist/css/select2.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Job Safety Analysis (JSA)
        <small>Form</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">JSA</li>
    </ol>
</section>
@endsection
@section('content')



<div class="row">
    <form id="form_jsa_add">
        <input type="hidden" name="wp_id" value="{{ $wp->id }}">
        <div class="col-md-12">
            
            <div class="box box-default">
                <div class="box-header with-border">
                    <b>A. INFORMASI PEKERJAAN</b>
                    <div class="box-tools">
                        
                    </div>
                </div>
                <div class="box-body">
                    
                    <div class="form-group">
                        <label for="">Tgl. Pengajuan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->tgl_pengajuan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->jenis_pekerjaan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Lokasi Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->lokasi_pekerjaan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Detail Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->detail_pekerjaan }}">
                    </div>
                    <div class="form-group">
                        <label for="">Perusahaan Pelaksana Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->users->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">Pengawas Pekerjaan</label>
                        <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->workPermitPP->pegawai->nama }}">
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Pelaksana Pekerjaan</label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <select class="form-control select2" multiple placeholder="Nama" name="pp_id[]" style="width: 100%">
                                    @foreach ($pegawai as $pg)
                                        <option value="{!! $pg->id !!}">{!! $pg->nama !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            
            <div class="box box-default">
                <div class="box-header with-border">
                    <b>B. PERALATAN KESELAMATAN</b>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <b>1. ALAT PELINDUNG DIRI</b>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_helm" id="apd_helm">
                                        Helm
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sepatu_safety" id="apd_sepatu_safety">
                                        Sepatu Safety
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_kacamata" id="apd_kacamata">
                                        Kacamata
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_earplug" id="apd_earplug">
                                        Earplug
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_earmuff" id="apd_earmuff">
                                        Earmuff
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_katun" id="apd_sarung_tangan_katun">
                                        Sarung Tangan Katun
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_karet" id="apd_sarung_tangan_karet">
                                        Sarung Tangan Karet
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_20kv" id="apd_sarung_tangan_20kv">
                                        Sarung Tangan 20 KV
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_pelampung" id="apd_pelampung">
                                        Pelampung / Life Vest
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_tabung_pernafasan" id="apd_tabung_pernafasan">
                                        Tabung Pernafasan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_full_body_harness" id="apd_full_body_harness">
                                        Full Body Harness
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_lain" id="apd_lain">
                                        Lain-lain, sebutkan :
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea readonly name="apd_lain_v" id="apd_lain_v" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" disabled id="btn_apd_lain" class="btn-xs btn-primary">Simpan Lain-lain</button>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <b>2. PERLENGKAPAN KESELAMATAN DAN DARURAT</b>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_pemadam_api" id="pkd_pemadam_api">
                                        Pemadam Api (APAR dll)
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_rambu_keselamatan" id="pkd_rambu_keselamatan">
                                        Rambu Keselamatan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_loto" id="pkd_loto">
                                        LOTO (lock out tag out)
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_radio_komunikasi" id="pkd_radio_komunikasi">
                                        Radio Komunikasi
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_safety_line" id="pkd_safety_line">
                                        Safety Line
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_kotak_p3k" id="pkd_kotak_p3k">
                                        Kotak P3K
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_lain" id="pkd_lain">
                                        Lain-lain, sebutkan :
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea readonly name="pkd_lain_v" id="pkd_lain_v" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="button" disabled id="btn_pkd_lain" class="btn-xs btn-primary">Simpan Lain-lain</button>
                            </div>
                        </div>
                        
                        
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <b>C.1 ANALISIS KESELAMATAN KERJA (UPLOAD)</b>
                </div>
                <div class="box-body">
                    <div class="callout callout-info">
                        <h4>Isi template uploader terlebih dahulu !</h4>
                        <p><a href="{!! url('template-analisis-keselamatan-kerja.xlsx') !!}" target="_blank" class="">Download File Uploader</a></p>
                    </div>

                    <div class="form-group">
                        <label for="">File Upload</label>
                        <input type="file" name="file" class="form-control"/>
                    </div>
                </div>
            </div>

            
            <div class="box box-default">
                <div class="box-header with-border">
                    <b>C.2 ANALISIS KESELAMATAN KERJA (MANUAL)</b>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">LANGKAH PEKERJAAN</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">POTENSI BAHAYA DAN RISIKO</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">TINDAKAN PENGENDALIAN DAN PENGGUNAAN APD</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp1" placeholder="" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="pbr1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp1_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp1_rambu[]" class="form-control select2 tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="lp2" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="pbr2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp2" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp2_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp2_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="pbr3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp3" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp3_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp3_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="pbr4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp4" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp4_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp4_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr5" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp5_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp5_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp6" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr6" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp6" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp6_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp6_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp7" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr7" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp7" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp7_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp7_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp8" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr8" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp8" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp8_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp8_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp9" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr9" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp9" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp9_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp9_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" name="lp10" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea name="pbr10" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" name="tp10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <select type="text" name="tp10_apd[]" class="form-control tp_apd_select select2" multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <select type="text" name="tp10_rambu[]" class="form-control tp_rambu" multiple></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <button type="button" class="btn btn-success btn-save">Simpan</button>
        </div>
        
    </form>
</div>
@endsection
@section('js')
<script src="{!! asset('admin/bower_components/select2/dist/js/select2.full.min.js') !!}"></script>


<script type="text/javascript">
    $('.select2').select2()

    var tp_apd = []
    var tp_rambu = []
    


    $("#apd_lain").change(function() {
        if(this.checked) {
            $('#apd_lain_v').attr('readonly', false);
            $('#btn_apd_lain').attr('disabled', false);
            $('#apd_lain_v').focus()
        }else{
            var v = $('#apd_lain_v').val()
            $('#apd_lain_v').attr('readonly', true);
            $('#btn_apd_lain').attr('readonly', true);
            $('#apd_lain_v').val('')

            var myIndex = tp_apd.indexOf(v);
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }

            reloadTpApd()
        }
    });

    $(document).on('click','#btn_apd_lain', function(){
        var v = $('#apd_lain_v').val()

        tp_apd.push(v)
        reloadTpApd()
        $('#apd_lain_v').attr('readonly', true);
        $('#btn_apd_lain').attr('disabled', true);
    })


    $("#pkd_lain").change(function() {
        if(this.checked) {
            $('#pkd_lain_v').attr('readonly', false);
            $('#btn_pkd_lain').attr('disabled', false);
            $('#pkd_lain_v').focus()
        }else{
            var v = $('#pkd_lain_v').val()
            $('#pkd_lain_v').attr('readonly', true);
            $('#btn_pkd_lain').attr('readonly', true);
            $('#pkd_lain_v').val('')

            var myIndex = tp_rambu.indexOf(v);
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }

            reloadTpRambu()
        }
    });

    $(document).on('click','#btn_pkd_lain', function(){
        var v = $('#pkd_lain_v').val()

        tp_rambu.push(v)
        reloadTpRambu()
        $('#pkd_lain_v').attr('readonly', true);
        $('#btn_pkd_lain').attr('disabled', true);
    })

    

    $("#pkd_pemadam_api").change(function() {
        if(this.checked) {
            tp_rambu.push("Pemadam Api (APAR dll)")
        }else{
            var myIndex = tp_rambu.indexOf('Pemadam Api (APAR dll)');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    $("#pkd_rambu_keselamatan").change(function() {
        if(this.checked) {
            tp_rambu.push("Rambu Keselamatan")
        }else{
            var myIndex = tp_rambu.indexOf('Rambu Keselamatan');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    $("#pkd_loto").change(function() {
        if(this.checked) {
            tp_rambu.push("LOTO (lock out tag out)")
        }else{
            var myIndex = tp_rambu.indexOf('LOTO (lock out tag out)');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    $("#pkd_radio_komunikasi").change(function() {
        if(this.checked) {
            tp_rambu.push("Radio Komunikasi")
        }else{
            var myIndex = tp_rambu.indexOf('Radio Komunikasi');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    $("#pkd_safety_line").change(function() {
        if(this.checked) {
            tp_rambu.push("Safety Line")
        }else{
            var myIndex = tp_rambu.indexOf('Safety Line');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    $("#pkd_kotak_p3k").change(function() {
        if(this.checked) {
            tp_rambu.push("Kotak P3K")
        }else{
            var myIndex = tp_rambu.indexOf('Kotak P3K');
            if (myIndex !== -1) {
                tp_rambu.splice(myIndex, 1);
            }
        }
        console.log(tp_rambu)
        reloadTpRambu()
    });

    function reloadTpRambu(){
        $('.tp_rambu').empty()
        var data = []
        $.each(tp_rambu, function(i, d){
            data.push(d)
        })

        $(".tp_rambu").select2({
            placeholder : 'Pilih Rambu K3',
            data: data
        })
    }



    $("#apd_helm").change(function() {
        if(this.checked) {
            tp_apd.push("Helm")
        }else{
            var myIndex = tp_apd.indexOf('Helm');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });

    $("#apd_sepatu_safety").change(function() {
        if(this.checked) {
            tp_apd.push("Sepatu Safety")
        }else{
            var myIndex = tp_apd.indexOf('Sepatu Safety');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });

    $("#apd_kacamata").change(function() {
        if(this.checked) {
            tp_apd.push("Kacamata")
        }else{
            var myIndex = tp_apd.indexOf('Kacamata');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });

   

    $("#apd_earplug").change(function() {
        if(this.checked) {
            tp_apd.push("Earplug")
        }else{
            var myIndex = tp_apd.indexOf('Earplug');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    $("#apd_earmuff").change(function() {
        if(this.checked) {
            tp_apd.push("Earplug")
        }else{
            var myIndex = tp_apd.indexOf('Earplug');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    $("#apd_sarung_tangan_katun").change(function() {
        if(this.checked) {
            tp_apd.push("Sarung Tangan Katun")
        }else{
            var myIndex = tp_apd.indexOf('Sarung Tangan Katun');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    $("#apd_sarung_tangan_karet").change(function() {
        if(this.checked) {
            tp_apd.push("Sarung Tangan Karet")
        }else{
            var myIndex = tp_apd.indexOf('Sarung Tangan Karet');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    $("#apd_sarung_tangan_20kv").change(function() {
        if(this.checked) {
            tp_apd.push("Sarung Tangan 20 KV")
        }else{
            var myIndex = tp_apd.indexOf('Sarung Tangan 20 KV');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    $("#apd_pelampung").change(function() {
        if(this.checked) {
            tp_apd.push("Pelampung / Life Vest")
        }else{
            var myIndex = tp_apd.indexOf('Pelampung / Life Vest');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    
    $("#apd_tabung_pernafasan").change(function() {
        if(this.checked) {
            tp_apd.push("Tabung Pernafasan")
        }else{
            var myIndex = tp_apd.indexOf('Tabung Pernafasan');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });

    $("#apd_full_body_harness").change(function() {
        if(this.checked) {
            tp_apd.push("Full Body Harness")
        }else{
            var myIndex = tp_apd.indexOf('Full Body Harness');
            if (myIndex !== -1) {
                tp_apd.splice(myIndex, 1);
            }
        }
        console.log(tp_apd)
        reloadTpApd()
    });
    


    function reloadTpApd(){
        $('.tp_apd_select').empty()
        var data = []
        $.each(tp_apd, function(i, d){
            data.push(d)
        })

        $(".tp_apd_select").select2({
            placeholder : 'Pilih APD',
            data: data
        })
    }

    // $('.tp_rambu').empty()
    // $(".tp_rambu").select2({
    //         placeholder : 'Pilih Rambu K3',
    //         data: ['Batas area kerja','Kunci pengaman (Lock Out)','Rambu peringatan (Taging Out)']
    //     })

        

    
    $(document).on('click','.btn-save', function(){
        $('#form_jsa_add').submit()
    })
    
    $('#form_jsa_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('jsa/create') !!}",
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
                    ).then(function(){
                        window.location = "{!! url('work-permit/detail?id='.$wp->id) !!}"
                    })
                }
            }
        })
    })
    
    
    $(document).on("click", ".btn-delete", function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                del(id)
            }
        })
    });
    
    
    function del(id) {
        $.ajax({
            type: 'get',
            url: "{!! url('jsa/delete?id=') !!}"+id,
            success: function (r) {
                console.log(r)
                if (r == 'success') {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                    location.reload()
                }
            }
        })
    }
</script>



@endsection
