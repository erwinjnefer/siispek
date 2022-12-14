@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Job Safety Analysis (JSA)
        <small>Form</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('work-permit/detail?id='.$wp->id) !!}"><i class="fa fa-book"></i> Work Permit</a></li>
        <li class="active">JSA</li>
    </ol>
</section>
@endsection
@section('content')

<div class="modal fade" id="upload-analisis-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_upload_analisis" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload Analisis Keselamatan Kerja</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="jsa_id" value="{{ $jsa->id }}">
                    <div class="form-group">
                        <label for="">File Uploader</label>
                        <input type="file" name="file" class="form-control" required/>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <a href="{!! url('template-analisis-keselamatan-kerja.xlsx') !!}" target="_blank" class="btn btn-success pull-right">Download File Uploader</a>
                    <button type="submit" class="btn btn-primary pull-left">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="review-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_review" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Review JSA</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="jsa_id" value="{{ $jsa->id }}">
                    <div class="form-group">
                        <select id="review" name="review" class="form-control" required>
                            <option>JSA telah di review dan disetujui</option>
                            <option>JSA belum disetujui dan perlu koreksi lebih lanjut</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-left">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<div class="row">
        
        <div class="col-md-12">

            @if($jsa->review == 'JSA telah di review dan disetujui')
            <div class="callout callout-success">
                <h4>Review !</h4>
                <p>JSA telah di review dan disetujui</p>
            </div>
            @endif

            @if($jsa->review == 'JSA belum disetujui dan perlu koreksi lebih lanjut')
            <div class="callout callout-danger">
                <h4>Review !</h4>
                <p>JSA belum disetujui dan perlu koreksi lebih lanjut <br>Catatan : {!! $jsa->note !!}</p>
            </div>

            <div class="row">
                
                <div class="col-md-2">
                    <button class="btn btn-danger form-control btn-reset-jsa" data-id="{{ $jsa->id }}"><i class="fa fa-refresh"></i> RESET JSA</button>
                </div>
            </div>
            
            @endif
            
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
                        <div class="col-md-12">

                            <label for="">Pelaksana Pekerjaan</label>
                            
                            @foreach ($jsa->jsaPegawai as $jp)
                            <div class="form-group">
                                <input type="text" class="form-control" readonly value="{!! $jp->pegawai->nama !!}">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="" class="btn btn-primary">Kondisi </a>
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
                                        <input type="checkbox" name="apd_helm" {{ $jsa->apd_helm == 'on' ? 'checked' : '' }}>
                                        Helm
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sepatu_safety" {{ $jsa->apd_sepatu_safety == 'on' ? 'checked' : '' }}>
                                        Sepatu Safety
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_kacamata" {{ $jsa->apd_kacamata == 'on' ? 'checked' : '' }}>
                                        Kacamata
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_earplug" {{ $jsa->apd_earplug == 'on' ? 'checked' : '' }}>
                                        Earplug
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_earmuff" {{ $jsa->apd_earmuff == 'on' ? 'checked' : '' }}>
                                        Earmuff
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_katun" {{ $jsa->apd_sarung_tangan_katun == 'on' ? 'checked' : '' }}>
                                        Sarung Tangan Katun
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_karet" {{ $jsa->apd_sarung_tangan_karet == 'on' ? 'checked' : '' }}>
                                        Sarung Tangan Karet
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_sarung_tangan_20kv" {{ $jsa->apd_sarung_tangan_20kv == 'on' ? 'checked' : '' }}>
                                        Sarung Tangan 20 KV
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_pelampung" {{ $jsa->apd_pelampung == 'on' ? 'checked' : '' }}>
                                        Pelampung / Life Vest
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_tabung_pernafasan" {{ $jsa->apd_tabung_pernafasan == 'on' ? 'checked' : '' }}>
                                        Tabung Pernafasan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_full_body_harness" {{ $jsa->apd_full_body_harness == 'on' ? 'checked' : '' }}>
                                        Full Body Harness
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd_lain" {{ $jsa->apd_lain == 'on' ? 'checked' : '' }}>
                                        Lain-lain, sebutkan :
                                    </label>
                                </div>
                            </div>
                            @if($jsa->apd_lain == 'on')
                            <div class="form-group">
                                <textarea readonly class="form-control" rows="3">{!! $jsa->apd_lain_v !!}</textarea>
                            </div>
                            @endif
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
                                        <input type="checkbox" name="pkd_pemadam_api" {{ $jsa->pkd_pemadam_api == 'on' ? 'checked' : '' }}>
                                        Pemadam Api (APAR dll)
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_rambu_keselamatan" {{ $jsa->pkd_rambu_keselamatan == 'on' ? 'checked' : '' }}>
                                        Rambu Keselamatan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_loto" {{ $jsa->pkd_loto == 'on' ? 'checked' : '' }}>
                                        LOTO (lock out tag out)
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_radio_komunikasi" {{ $jsa->pkd_radio_komunikasi == 'on' ? 'checked' : '' }}>
                                        Radio Komunikasi
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="pkd_lain" {{ $jsa->pkd_lain == 'on' ? 'checked' : '' }}>
                                        Lain-lain, sebutkan :
                                    </label>
                                </div>
                            </div>

                            @if($jsa->pkd_lain == 'on')
                            <div class="form-group">
                                <textarea readonly class="form-control" rows="3">{!! $jsa->pkd_lain_v !!}</textarea>
                            </div>
                            @endif
                        </div>
                        
                        
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            
            <div class="box box-default">
                <div class="box-header with-border">
                    <b>C. ANALISIS KESELAMATAN KERJA</b>
                    <div class="box-tools">
                        <button data-toggle="modal" data-target="#upload-analisis-modal" class="btn btn-primary">Upload</button>
                    </div>
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
                                <label for="">TINDAKAN PENGENDALIAN</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp1 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr1 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp1 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp1_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp1_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp2 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr2 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp2 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp2_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp2_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp3 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr3 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp3 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp3_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp3_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp4 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr4 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp4 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp4_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp4_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp5 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr5 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp5 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp5_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp5_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp6 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr6 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp6 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp6_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp6_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp7 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr7 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp7 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp7_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp7_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp8 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr8 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp8 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp8_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp8_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp9 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr9 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp9 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp9_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp9_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea rows="2" class="form-control" readonly>{!! $jsa->lp10 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <textarea class="form-control" rows="2" readonly>{!! $jsa->pbr10 !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp10 !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="APD">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp10_apd !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12" title="Rambu K3">
                                    <div class="form-group">
                                        <textarea rows="2" class="form-control" readonly>{!! $jsa->tp10_rambu !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    

                    
                    
                    
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            @if(Auth::user()->level == 2)
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#review-modal" class="btn btn-primary">REVIEW</a>
            @endif
            <a class="btn btn-warning" target="_blank" href="{{ url('jsa/preview?id='.$jsa->id) }}" class="btn btn-primary">PDF</a>
            <a class="btn btn-primary" href="{{ url('work-permit/detail?id='.$wp->id) }}" class="btn btn-primary">KEMBALI</a>
        </div>
        

</div>
@endsection
@section('js')


<script type="text/javascript">
    $(":checkbox").on("click", false);
    
    $(document).on('click','.btn-save', function(){
        $('#form_jsa_add').submit()
    })

    $('#form_upload_analisis').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('jsa/import-analisis') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                console.log(r)
                if (r.msg == 'success') {
                    Swal.fire(
                    'Yeaa !',
                    'Simpan data berhasil !',
                    'success'
                    ).then(function(){
                        location.reload()
                    })
                }
            }
        })
    })

    $('#form_review').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('jsa/review') !!}",
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
                        location.reload()
                    })
                }
            }
        })
    })

    $(document).on("click", ".btn-reset-jsa", function (e) {
        e.preventDefault()
        var id = $(this).data('id');
        console.log(id)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset JSA!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'get',
                    url: "{!! url('jsa/reset?id=') !!}"+id,
                    success: function (r) {
                        console.log(r)
                        if (r == 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(function(){
                                window.location = "{{ url('jsa/form?wp_id='.$wp->id) }}"
                            })
                        }
                    }
                })
            }
        })
    });
    
   
    

</script>



@endsection
