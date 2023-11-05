@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('chocolat/dist/css/chocolat.css') }}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Inspeksi
        <small>Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('inspeksi') !!}"><i class="fa fa-check"></i> Inspeksi</a></li>
        <li class="active">Inspeksi Detail</li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
    
    {{-- <div class="modal fade" id="review-im-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_review_im" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Review Inspeksi Mandiri</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="{{ $wp->inspeksi->id }}">

                        <div class="form-group">
                            <label for="">Status Review</label>
                            <select class="form-control" name="status_review">
                                <option>Inpseksi Mandiri telah direview dan Valid</option>
                                <option>SWA</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="inspeksi-mandiri-review">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_inspeksi_mandiri_review" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Inspeksi Mandiri</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="im_id" id="im_id">
                        <div class="form-group">
                            <label for="">Kondisi Pelaksana Pekerjaan</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_kondisi_pelaksana_pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="">Penggunaan APD</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_penggunaan_apd">
                        </div>
                        <div class="form-group">
                            <label for="">Penggunaan Perlengkapan Kerja</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_penggunaan_perlengkapan_kerja">
                        </div>
                        <div class="form-group">
                            <label for="">Pemasangan Rambu K3</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_pemasangan_rambu_k3">
                        </div>
                        <div class="form-group">
                            <label for="">Pemasangan LOTO</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_pemasangan_loto">
                        </div>
                        <div class="form-group">
                            <label for="">Pemasangan Pembumian</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_pemasangan_pembumian">
                        </div>
                        <div class="form-group">
                            <label for="">Pembebasan/Pemeriksaan Tegangan</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_pembebasasn_pemeriksaan_tegangan">
                        </div>
                        <div class="form-group">
                            <label for="">Pelaksanaan Briefing K3 di Lokasi</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_pelaksanaan_breafing">
                        </div>
                        <div class="form-group">
                            <label for="">JSA</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_jsa">
                        </div>
                        <div class="form-group">
                            <label for="">SOP</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_sop">
                        </div>
                        <div class="form-group">
                            <label for="">WP</label>
                            <input type="text" class="form-control" placeholder="" readonly id="r_wp">
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <img src="" id="r_foto" style="width: 100%">
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" class="btn btn-primary pull-left">Approve</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sign-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form id="form_sign" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Yakin untuk Approve ?</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="sign_dest" id="sign_dest">
                        <input type="hidden" name="id" id="app_il_id">

                        
                        {{-- <div class="form-group">    
                            <canvas id="sig-canvas" width="500" height="160">
                            </canvas>
                        </div>
                        <div class="form-group">
                            <textarea name="sign_url" readonly class="form-control" id="sig-dataUrl" rows="5"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="sig-submitBtn">Submit Signature</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" id="sig-clearBtn">Clear Signature</button>
                                </div>
                            </div>
                        </div> --}}
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-right" id="btn-save-sign">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="create-inspeksi-lanjut-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_create_inspeksi_lanjut" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Input Inspeksi Lanjut</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="il_id">
                        <div class="form-group">
                            <label for="">Kondisi Pelaksana Pekerjaan</label>
                            <select class="form-control" name="kondisi_pelaksana_pekerjaan" id="kondisi_pelaksana_pekerjaan">
                                <option>Seluruh Tenaga Kerja dalam kondisi laik kerja</option>
                                <option>Terdapat Tenaga Kerja kondisi tidak laik kerja</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Penggunaan APD</label>
                            <select class="form-control" name="penggunaan_apd" id="penggunaan_apd">
                                <option>Seluruh APD terpakai sesuai SOP</option>
                                <option>APD tidak terpakai</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Penggunaan Perlengkapan Kerja</label>
                            <select class="form-control" name="penggunaan_perlengkapan_kerja" id="penggunaan_perlengkapan_kerja">
                                <option>Seluruh peralatan kerja dalam kondisi layak pakai dan terpakai</option>
                                <option>Terdapat peralatan kerja kondisi tidak layak pakai</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan Rambu K3</label>
                            <select class="form-control" name="pemasangan_rambu_k3" id="pemasangan_rambu_k3">
                                <option>Seluruh rambu K3 terpasang sesuai SOP</option>
                                <option>Rambu K3 tidak terpasang</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan LOTO</label>
                            <select class="form-control" name="pemasangan_loto" id="pemasangan_loto">
                                <option>Seluruh LOTO terpasang sesuai SOP</option>
                                <option>LOTO tidak terpasang</option>
                                <option>Tidak memerlukan LOTO</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan Pembumian</label>
                            <select class="form-control" name="pemasangan_pembumian" id="pemasangan_pembumian">
                                <option>Grounding terpasang sesuai SOP</option>
                                <option>Grounding tidak terpasang</option>
                                <option>Tidak memerlukan pembumian</option>
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="">Pembebasan/Pemeriksaan Tegangan</label>
                            <select class="form-control" name="pembebasasn_pemeriksaan_tegangan" id="pembebasasn_pemeriksaan_tegangan">
                                <option>Pembebasan Tegangan instalasi telah dilakukan dan aman bekerja</option>
                                <option>Instalasi masih bertegangan dan aman</option>
                                <option>Instalasi masih bertegangan dan tidak aman</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pelaksanaan Briefing K3 di Lokasi</label>
                            <select class="form-control" name="pelaksanaan_breafing" id="pelaksanaan_breafing">
                                <option>Briefing dilakukan sesuai SOP</option>
                                <option>Briefing tidak dilaksanakan</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Job Safety Analysis</label>
                            <select class="form-control" name="jsa" id="jsa">
                                <option>JSA dibuat dan diisi sesuai pekerjaan</option>
                                <option>JSA tidak dibuat</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">SOP</label>
                            <select class="form-control" name="sop" id="sop">
                                <option>SOP dibuat sesuai pekerjaan</option>
                                <option>SOP tidak dibuat</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Work Permit</label>
                            <select class="form-control" name="wp" id="wp">
                                <option>Work Permit telah dibuat</option>
                                <option>Work Permit tidak dibuat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <input class="form-control" name="lokasi" id="lokasi" required>
                        </div>

                        <div class="form-group">
                            <label for="">Catatan / Temuan Yang Perlu Dilaporkan</label>
                            <textarea class="form-control" name="catatan_temuan" id="catatan_temuan" rows="5"></textarea>
                         </div>

                        <div class="form-group">
                            <label for="">Saran / Rekomendasi Perbaikan</label>
                            <textarea class="form-control" name="saran_rekomendasi" id="saran_rekomendasi" rows="5"></textarea>
                         </div>

                        <div class="form-group">
                            <label for="">Tindakan Selanjutnya</label>
                            <select class="form-control" name="tindakan_selanjutnya" id="tindakan_selanjutnya">
                                <option>Pekerjaan dapat dilanjutkan</option>
                                <option>Pekerjaan tidak dapat dilanjutkan dan diterbitkan SWA (stop work authority)</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-inspeksi-lanjut-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_edit_inspeksi_lanjut" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Input Inspeksi Lanjut</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="e_il_id">
                        <div class="form-group">
                            <label for="">Kondisi Pelaksana Pekerjaan</label>
                            <select class="form-control" name="kondisi_pelaksana_pekerjaan" id="kondisi_pelaksana_pekerjaan">
                                <option>Seluruh Tenaga Kerja dalam kondisi laik kerja</option>
                                <option>Terdapat Tenaga Kerja kondisi tidak laik kerja</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Penggunaan APD</label>
                            <select class="form-control" name="penggunaan_apd" id="penggunaan_apd">
                                <option>Seluruh APD terpakai sesuai SOP</option>
                                <option>APD tidak terpakai</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Penggunaan Perlengkapan Kerja</label>
                            <select class="form-control" name="penggunaan_perlengkapan_kerja" id="penggunaan_perlengkapan_kerja">
                                <option>Seluruh peralatan kerja dalam kondisi layak pakai dan terpakai</option>
                                <option>Terdapat peralatan kerja kondisi tidak layak pakai</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan Rambu K3</label>
                            <select class="form-control" name="pemasangan_rambu_k3" id="pemasangan_rambu_k3">
                                <option>Seluruh rambu K3 terpasang sesuai SOP</option>
                                <option>Rambu K3 tidak terpasang</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan LOTO</label>
                            <select class="form-control" name="pemasangan_loto" id="pemasangan_loto">
                                <option>Seluruh LOTO terpasang sesuai SOP</option>
                                <option>LOTO tidak terpasang</option>
                                <option>Tidak memerlukan LOTO</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pemasangan Pembumian</label>
                            <select class="form-control" name="pemasangan_pembumian" id="pemasangan_pembumian">
                                <option>Grounding terpasang sesuai SOP</option>
                                <option>Grounding tidak terpasang</option>
                                <option>Tidak memerlukan pembumian</option>
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="">Pembebasan/Pemeriksaan Tegangan</label>
                            <select class="form-control" name="pembebasasn_pemeriksaan_tegangan" id="pembebasasn_pemeriksaan_tegangan">
                                <option>Pembebasan Tegangan instalasi telah dilakukan dan aman bekerja</option>
                                <option>Instalasi masih bertegangan dan aman</option>
                                <option>Instalasi masih bertegangan dan tidak aman</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Pelaksanaan Briefing K3 di Lokasi</label>
                            <select class="form-control" name="pelaksanaan_breafing" id="pelaksanaan_breafing">
                                <option>Briefing dilakukan sesuai SOP</option>
                                <option>Briefing tidak dilaksanakan</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Job Safety Analysis</label>
                            <select class="form-control" name="jsa" id="jsa">
                                <option>JSA dibuat dan diisi sesuai pekerjaan</option>
                                <option>JSA tidak dibuat</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">SOP</label>
                            <select class="form-control" name="sop" id="sop">
                                <option>SOP dibuat sesuai pekerjaan</option>
                                <option>SOP tidak dibuat</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Work Permit</label>
                            <select class="form-control" name="wp" id="wp">
                                <option>Work Permit telah dibuat</option>
                                <option>Work Permit tidak dibuat</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <input class="form-control" name="lokasi" id="e_lokasi" required>
                        </div>

                        <div class="form-group">
                            <label for="">Catatan / Temuan Yang Perlu Dilaporkan</label>
                            <textarea class="form-control" name="catatan_temuan" id="e_catatan_temuan" rows="5"></textarea>
                         </div>

                        <div class="form-group">
                            <label for="">Saran / Rekomendasi Perbaikan</label>
                            <textarea class="form-control" name="saran_rekomendasi" id="e_saran_rekomendasi" rows="5"></textarea>
                         </div>

                        <div class="form-group">
                            <label for="">Tindakan Selanjutnya</label>
                            <select class="form-control" name="tindakan_selanjutnya" id="e_tindakan_selanjutnya">
                                <option>Pekerjaan dapat dilanjutkan</option>
                                <option>Pekerjaan tidak dapat dilanjutkan dan diterbitkan SWA (stop work authority)</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-foto-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_foto_add" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Upload Foto</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="inspeksi_id" id="f_il_id">
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" required name="foto" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> --}}
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-foto-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content foto-list">
                
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        @if($wp->inspeksi != null && $wp->inspeksi->status == 'SWA')
        <div class="callout callout-danger">
            <h4>SWA !</h4>
            <p>Untuk membuka status swa pastikan dokumen wp sdh lengkap/temuan inspeksi sudah ditindaklanjuti</p>
            @if($wp->inspeksi->req_open_swa == 1 )
                <p><b>File Eviden : <a href="{{ url($wp->inspeksi->req_open_swa_file) }}" target="_blank">{{ $wp->inspeksi->req_open_swa_file }}</a></b></p>
            @endif
        </div>

        

        @if(Auth::user()->level == 2 && $wp->wpApproval->man_app != null && $wp->inspeksi->req_open_swa == 1)
        <button class="btn btn-success btn-open-swa" data-id="{{ $wp->inspeksi->id }}"><i class="fa fa-check"></i> Open SWA</button>
        @endif
        <br>
        <br>
        @endif

        @if($wp->wpApproval->man_app == null)
        <div class="callout callout-danger">
            <h4>Warning !</h4>
            <p>Approval WP belum selesai</p>
        </div>
        @endif

        
        <div class="box">
            <div class="box-header with-border">
                <h4>I. INFORMASI PEKERJAAN</h4>
                <div class="box-tools">
                    @if($wp->inspeksi != null)
                
                    @endif
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
                    <label for="">Detail Pekerjaan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->detail_pekerjaan }}">
                </div>
                <div class="form-group">
                    <label for="">Unit Kerja PLN</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->unit->nama }}">
                </div>
                <div class="form-group">
                    <label for="">Perusahaan Pelaksana Pekerjaan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->users->name }}">
                </div>
                
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4>II. INFORMASI PERSONIL</h4>
            </div>
            <div class="box-body">
                
                <div class="form-group">
                    <label for="">Nama Pengawas Pekerjaan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->workPermitPP->pegawai->nama }}">
                </div>
                <div class="form-group">
                    <label for="">Nama Pengawas K3 Pekerjaan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->workPermitPPK3->pegawai->nama }}">
                </div>
                
                @php
                $pelaksana = "";
                $c = 1;
                foreach ($wp->jsa->jsaPegawai as $jp) {
                    $pelaksana = $pelaksana.$c++ .'. '.$jp->pegawai->nama."\n";
                }
                @endphp
                <div class="form-group">
                    <label for="">Nama Pelaksana Pekerjaan</label>
                    <textarea class="form-control" placeholder="" readonly rows="6">{!! $pelaksana !!}</textarea>
                </div>
                
            </div>
            <div class="box-footer">
                Lampiran :
                <br>
                @if($wp->kategori == 'form')
                <a href="{!! url('work-permit/print?id='.$wp->id) !!}" target="_blank"><span class="badge bg-aqua">Work Permit</span></a>
                <a href="{!! url('jsa/preview?id='.$wp->jsa->id) !!}" target="_blank"><span class="badge bg-aqua">File JSA</span></a>
                @else
                    @if($wp->wp_file != null)
                    <a href="{!! url($wp->wp_file) !!}" target="_blank"><span class="badge bg-aqua">File Work Permit & JSA</span></a>
                    @else
                    <a href="#" target="_blank" class="btn-open-inspekta"><span class="badge bg-aqua">File Work Permit & JSA</span></a>
                    @endif
                @endif
                <a href="{!! url($wp->workPermitProsedurKerja->prosedurKerja->file) !!}" target="_blank"><span class="badge bg-aqua">File SOP</span></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4>III. INSPEKSI MANDIRI</h4>
                <div class="box-tools">
                </div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="1%">NO</th>
                        <th width="15%">NAMA PEGAWAI</th>
                        <th style="text-align: center" width="5%">INSPEKSI TERAHKIR</th>
                        <th style="text-align: center" width="5%">DETAIL INSPEKSI</th>
                    </tr>
                    @php
                        $no = 1;
                    @endphp
                    @if($wp->inspeksi != null)
                    @foreach ($wp->inspeksi->inspeksiMandiri as $im)
                        <tr>
                            <td>{{ $no ++ }}</td>
                            <td>{{ $im->jsaPegawai->pegawai->nama }}</td>
                            <td align="center">{{ date('d-m-Y', strtotime($im->tgl_inspeksi)) }}</td>
                            <td align="center">
                                <a href="#" class="btn-review-im"
                                data-id="{{ $im->id }}"
                                data-kondisi_pelaksana_pekerjaan="{{ $im->kondisi_pelaksana_pekerjaan }}"
                                data-penggunaan_apd="{{ $im->penggunaan_apd }}"
                                data-penggunaan_perlengkapan_kerja="{{ $im->penggunaan_perlengkapan_kerja }}"
                                data-pemasangan_rambu_k3="{{ $im->pemasangan_rambu_k3 }}"
                                data-pemasangan_loto="{{ $im->pemasangan_loto }}"
                                data-pemasangan_pembumian="{{ $im->pemasangan_pembumian }}"
                                data-pembebasasn_pemeriksaan_tegangan="{{ $im->pembebasasn_pemeriksaan_tegangan }}"
                                data-pelaksanaan_breafing="{{ $im->pelaksanaan_breafing }}"
                                data-sop="{{ $im->sop }}"
                                data-jsa="{{ $im->jsa }}"
                                data-wp="{{ $im->wp }}"
                                data-foto="{{ asset($im->foto) }}"
                                >Detail</a>
                            </td>
                        </tr>
                    @endforeach
                    @endif

                </table>
                
                
                
                
                
            </div>
        </div>
    </div>
    
   

    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h4>INSPEKSI LANJUT</h4>
                <div class="box-tools">
                    @if($wp->inspeksi != null && $wp->inspeksi->status != 'SWA')
                    <button type="button" class="btn btn-success btn-sm btn-create-inspeksi-lanjut" data-id="{{ $wp->inspeksi != null ? $wp->inspeksi->id : '' }}" ><i class="fa fa-pencil"></i> Inspeksi Lanjut</button>
                    @endif
                </div>
                
            </div>
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>NO</th>
                        <th>DATE</th>
                        <th>LOKASI</th>
                        <th>IV. CATATAN TEMUAN</th>
                        <th>V. SARAN / REKOMENDASI PERBAIKAN</th>
                        <th>VI. TINDAKAN SELANJUTNYA</th>
                        <th>FOTO</th>
                        <th>APPROVAL K3 VENDOR</th>
                        <th>APPROVAL K3 PLN</th>
                        <th style="text-align: center"><i class="fa fa-gear"></i></th>
                    </tr>
                    @if ($wp->inspeksi != null)
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($wp->inspeksi->inspeksiLanjut as $inspeksiLanjut)
                            <tr>
                                <td>{{ $no ++ }}</td>
                                <td>
                                    {{ date('d-m-Y', strtotime($inspeksiLanjut->date)) }}

                                    @if(Auth::user()->status == 'Admin')
                                    {{ $inspeksiLanjut->time }}
                                    @endif
                                </td>
                                <td>{{ $inspeksiLanjut->lokasi }}</td>
                                <td>{{ $inspeksiLanjut->catatan_temuan }}</td>
                                <td>{{ $inspeksiLanjut->saran_rekomendasi }}</td>
                                <td>{{ $inspeksiLanjut->tindakan_selanjutnya }}</td>
                                <td>
                                    @if($inspeksiLanjut->app_k3_vendor == NULL)
                                    <a href="#" class="btn-upload-foto" data-id="{{ $inspeksiLanjut->id }}"><span class="badge bg-green"><i class="fa fa-image-plus"></i> Upload Foto</span></a>
                                    @endif
                                    {{-- {!! count($inspeksiLanjut->inspeksiFoto) > 0 ? "<br>" : ''!!} --}}
                                    <div class="chocolat-parent">
                                    @foreach ($inspeksiLanjut->inspeksiFoto as $foto)
                                        <a class="chocolat-image" href="{{ url($foto->foto) }}"><span class="badge bg-aqua">{{ "img-".$foto->id }}</span></a>
                                    @endforeach
                                    </div>
                                </td>
                                <td align="center">
                                    @if ($inspeksiLanjut->tindakan_selanjutnya == 'Pekerjaan dapat dilanjutkan' && $inspeksiLanjut->app_k3_vendor != null)
                                    {!! QrCode::size(40)->generate('Approved by K3 Vendor'); !!}
                                    @endif
                                </td>
                                <td align="center">
                                    @if ($inspeksiLanjut->app_k3_pln != NULL)
                                    {!! QrCode::size(40)->generate('Approved by Pejabat K3'); !!}
                                    @elseif($inspeksiLanjut->app_k3_vendor != null && $inspeksiLanjut->app_k3_pln == NULL)
                                    <a href="#" class="btn-app-k3-pln" data-id="{{ $inspeksiLanjut->id }}"><span class="badge bg-blue">Approve</span></a>
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="#" class="btn-edit-inspeksi-lanjut" data-id="{{ $inspeksiLanjut->id }}" data-lokasi="{{ $inspeksiLanjut->lokasi }}" data-catatan_temuan="{{ $inspeksiLanjut->catatan_temuan }}"
                                        data-saran_rekomendasi="{{ $inspeksiLanjut->saran_rekomendasi }}" data-tindakan_selanjutnya="{{ $inspeksiLanjut->tindakan_selanjutnya }}">
                                        <span class="badge bg-blue"><i class="fa fa-pencil"></i> Update</span>
                                    </a>
                                    <a href="{!! url('inspeksi/export?id='.$wp->id.'&il_id='.$inspeksiLanjut->id) !!}"><span class="badge bg-green"><i class="fa fa-file-excel-o"></i> Export</span></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                
            </div>
        </div>
    </div>
  

 
    
</div>

@endsection
@section('js')
<script src="{{ asset('chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script>
    var instance = $('.chocolat-parent').Chocolat({
        loop: true,
        fullscreen: true,
        imageSize: 'contain'
    }).data('chocolate');

    $(document).on('click', '.btn-open-inspekta', function (e) {
        let params = `scrollbars=yes,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=1000,height=1000,left=100,top=100`;
        open("{{ $wp->url }}", 'Inspekta', params);
    })

    $(document).on('click', '.btn-review-im', function (e) {
        e.preventDefault()

        $('#im_id').val($(this).data('id'))
        $('#r_kondisi_pelaksana_pekerjaan').val($(this).data('kondisi_pelaksana_pekerjaan'))
        $('#r_penggunaan_apd').val($(this).data('penggunaan_apd'))
        $('#r_penggunaan_perlengkapan_kerja').val($(this).data('penggunaan_perlengkapan_kerja'))
        $('#r_pemasangan_rambu_k3').val($(this).data('pemasangan_rambu_k3'))
        $('#r_pemasangan_loto').val($(this).data('pemasangan_loto'))
        $('#r_pemasangan_pembumian').val($(this).data('pemasangan_pembumian'))
        $('#r_pembebasasn_pemeriksaan_tegangan').val($(this).data('pembebasasn_pemeriksaan_tegangan'))
        $('#r_pelaksanaan_breafing').val($(this).data('pelaksanaan_breafing'))
        $('#r_jsa').val($(this).data('jsa'))
        $('#r_sop').val($(this).data('sop'))
        $('#r_wp').val($(this).data('wp'))

        var foto = $(this).data('foto')
        $('#r_foto').attr('src', foto)

        $('#inspeksi-mandiri-review').modal('show')


    })


    $(document).on("click", ".btn-open-swa", function (e) {
        e.preventDefault()
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, open it!'
        }).then((result) => {
            if (result.value) {

                showPleaseWait()
                $.ajax({
                    type: 'get',
                    url: "{!! url('inspeksi/open-swa?id=') !!}" + id,
                    success: function (r) {
                        console.log(r)
                        hidePleaseWait()
                        if (r == 'success') {
                            Swal.fire(
                                'Submit !',
                                'Your data has been opened.',
                                'success'
                            ).then(function () {
                                location.reload()
                            })

                        }
                    }
                })
            }
        })
    });

    $(document).on("click", ".btn-submit-inspeksi", function (e) {
        e.preventDefault()
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.value) {

                showPleaseWait()
                $.ajax({
                    type: 'get',
                    url: "{!! url('inspeksi/submit?id=') !!}" + id,
                    success: function (r) {
                        console.log(r)
                        hidePleaseWait()
                        if (r == 'success') {
                            Swal.fire(
                                'Submit !',
                                'Your file has been submit.',
                                'success'
                            ).then(function () {
                                location.reload()
                            })

                        }
                    }
                })
            }
        })
    });




    $(document).on('click', '.btn-upload-foto', function (e) {
        e.preventDefault()
        $('#f_il_id').val($(this).data('id'))
        $('#add-foto-modal').modal('show')
    })

    $('#form_foto_add').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/upload-foto') !!}",
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
                    ).then(function () {
                        location.reload()
                    })
                }
            }
        })
    })

    $(document).on('click','.btn-upload-video', function(e){
        e.preventDefault()
        $('#add-video-modal').modal('show')
    })
    
    $('#form_video_add').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/upload-video') !!}",
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

    $(document).on('click','.btn-app-k3-pln', function(e){
        e.preventDefault()

        // $('#sign_dest').val($(this).data('sign_dest'))
        $('#app_il_id').val($(this).data('id'))
        $('#sign-modal').modal('show')

    })

  

    $('#form_sign').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/approve') !!}",
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

    
    $('#form_review_im').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/review-inspeksi-mandiri') !!}",
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


    $(document).on('click','.btn-create-inspeksi-lanjut', function(e){
        e.preventDefault()

        $('#il_id').val($(this).data('id'))
        // $('#catatan_temuan').val($(this).data('catatan_temuan'))
        $('#create-inspeksi-lanjut-modal').modal('show')
        
        
    })
    
    $('#form_create_inspeksi_lanjut').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/lanjut/create') !!}",
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

    $(document).on('click','.btn-edit-inspeksi-lanjut', function(e){
        e.preventDefault()

        $('#e_il_id').val($(this).data('id'))
        $('#e_lokasi').val($(this).data('lokasi'))
        $('#e_catatan_temuan').val($(this).data('catatan_temuan'))
        $('#e_saran_rekomendasi').val($(this).data('saran_rekomendasi'))
        $('#e_tindakan_selanjutnya').val($(this).data('tindakan_selanjutnya'))
        $('#edit-inspeksi-lanjut-modal').modal('show')
        
        
    })
    
    $('#form_edit_inspeksi_lanjut').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('inspeksi/lanjut/edit') !!}",
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




    $(document).on("click", ".btn-del-foto", function (e) {
        e.preventDefault()
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
                showPleaseWait()
                $.ajax({
                    type: 'get',
                    url: "{!! url('inspeksi/delete-foto?id=') !!}" + id,
                    success: function (r) {
                        console.log(r)
                        hidePleaseWait();
                        if (r == 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(function(){
                                location.reload()
                            })
                                
                        }
                    }
                })
            }
        })
    });

    $(document).on("click", ".btn-del-video", function (e) {
        e.preventDefault()
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
                showPleaseWait()
                $.ajax({
                    type: 'get',
                    url: "{!! url('inspeksi/delete-video?id=') !!}" + id,
                    success: function (r) {
                        console.log(r)
                        hidePleaseWait();
                        if (r == 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(function(){
                                location.reload()
                            })
                                
                        }
                    }
                })
            }
        })
    });
</script>
@endsection