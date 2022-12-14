@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">

@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Work Permit
        <small>Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('work-permit') !!}"><i class="fa fa-book"></i> Work Permit</a></li>
        <li class="active">Detail</li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
    <div class="modal fade" id="view-hirarc-modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Pilih HIRARC</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <select class="form-control" id="hirarc_select_jp">
                            <option value=""></option>
                            <option>Jaringan</option>
                            <option>PDKB</option>
                            <option>Konstruksi</option>
                            <option>Transaksi Energi</option>
                            <option>K3L</option>
                            <option>Umum</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Pilih FIle HIRARC</label>
                                <select class="form-control" id="hirarc_file_select"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Upload HIRARC</label>
                                <button id="btn-upload-hirarc" class="form-control btn-primary"> Upload</button>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="hirarc_wp_id" value="{!! $wp->id !!}">
                    <div class="form-group">
                        <iframe width="100%" height="800px" id="hirarc_iframe" frameborder="0"></iframe>
                    </div>

                    
                    
                    
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-save-hirarc" disabled class="btn btn-primary pull-left btn-hirarc-ok">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-hirarc-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_hirarc_add" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Upload HIRARC</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Jenis Pekerjaan</label>
                            <select class="form-control" name="jenis_pekerjaan">
                                <option>Jaringan</option>
                                <option>PDKB</option>
                                <option>Konstruksi</option>
                                <option>Transaksi Energi</option>
                                <option>K3L</option>
                                <option>Umum</option>
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

   {{-- Prosedur kerja --}}
   <div class="modal fade" id="view-pk-modal">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
                   <h4 class="modal-title">Pilih Prosedur Kerja</h4>
               </div>
               <div class="modal-body">

                   <div class="form-group">
                       <label for="">Jenis Pekerjaan</label>
                       <select class="form-control" id="pk_select_jp">
                           <option value=""></option>
                           <option>Jaringan</option>
                            <option>PDKB</option>
                            <option>Konstruksi</option>
                            <option>Transaksi Energi</option>
                            <option>K3L</option>
                            <option>Umum</option>
                       </select>
                   </div>

                   <div class="row">
                       <div class="col-md-8">
                           <div class="form-group">
                               <label for="">Pilih FIle Prosedur Kerja</label>
                               <select class="form-control" id="pk_file_select"></select>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="form-group">
                               <label for="">Upload Prosedur Kerja</label>
                               <button id="btn-upload-pk" class="form-control btn-primary"> Upload</button>
                           </div>
                       </div>
                   </div>

                   <input type="hidden" id="pk_wp_id" value="{!! $wp->id !!}">
                   <div class="form-group">
                       <iframe width="100%" height="1000px" id="pk_iframe" frameborder="0"></iframe>
                   </div>




               </div>
               <div class="modal-footer">
                   <button type="button" id="btn-save-pk" disabled class="btn btn-primary pull-left btn-pk-ok">Mengerti</button>
               </div>
           </div>
       </div>
   </div>

   <div class="modal fade" id="add-pk-modal">
       <div class="modal-dialog modal-lg">
           <div class="modal-content">
               <form id="form_pk_add" enctype="multipart/form-data">
                   <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                       <h4 class="modal-title">Upload Prosedur Kerja</h4>
                   </div>
                   <div class="modal-body">
                       @csrf
                       <div class="form-group">
                           <label for="">Jenis Pekerjaan</label>
                           <select class="form-control" name="jenis_pekerjaan">
                            <option>Jaringan</option>
                            <option>PDKB</option>
                            <option>Konstruksi</option>
                            <option>Transaksi Energi</option>
                            <option>K3L</option>
                            <option>Umum</option>
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

    <div class="modal fade" id="add-app-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_app_add">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Approve</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="{{ $wp->wpApproval->id }}">
                        <input type="hidden" id="kategori" name="kategori">
                        <div class="form-group">
                            <label for="">Approve</label>
                            <select class="form-control" name="app">
                                <option>Accept</option>
                                {{-- <option>Reject</option> --}}
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="">Ket</label>
                            <textarea class="form-control" name="ket"></textarea>
                        </div>
                        
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reject-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_reject">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Reject</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="{{ $wp->id }}">
                        <input type="hidden" id="r_kategori" name="kategori">
                
                        <div class="form-group">
                            <label for="">Catatan</label>
                            <textarea class="form-control" name="catatan"></textarea>
                        </div>
                        
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($wp->reject == 1)
    <div class="col-md-12">
        <div class="callout callout-danger">
            <h4>Rejected !</h4>
            <p>{{ $wp->reject_message }}</p>
            </div>
    </div>
    @endif
    
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h4>A. INFORMASI PEKERJAAN</h4>
            </div>
            <div class="box-body">
                
                <div class="form-group">
                    <label for="">Tgl. Pengajuan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->tgl_pengajuan }}">
                </div>
                <div class="form-group">
                    <label for="">SPK NO.</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->spp_no }}">
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
                    <label for="">Lokasi Pekerjaan</label>
                    <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->lokasi_pekerjaan }}">
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pengawas Pekerjaan</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPP->pegawai->nama !!}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPP->pegawai->no_wa !!}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pengawas K3</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPPK3->pegawai->nama !!}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->workPermitPPK3->pegawai->no_wa !!}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Pengawas Manuver</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->pengawasManuver->users->name !!}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">No. Telp</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{!! $wp->pengawasManuver->users->no_wa !!}">
                        </div>
                    </div>
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
                            <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->tgl_mulai }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Jam Mulai</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->jam_mulai }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Tgl. Selesai</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->tgl_selesai }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Jam Selesai</label>
                            <input type="text" class="form-control" placeholder="" readonly value="{{ $wp->jam_selesai }}">
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
                                <input type="checkbox" name="kp1" {{ $wp->kp1 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Bertegangan Listrik
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp2" {{ $wp->kp2 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Overhaul Mesin
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp3" {{ $wp->kp3 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Panas
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp4" {{ $wp->kp4 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Lainnya, sebutkan
                            </label>
                        </div>

                        @if ($wp->kp4 == 'on')
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" readonly  value="{{ $wp->kp4_lainnya }}" class="form-control">
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp5" {{ $wp->kp5 == 'on' ? 'checked' : '' }}>
                                Pekerjaan di Ketinggian
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp6" {{ $wp->kp6 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Penggalian
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp7" {{ $wp->kp7 == 'on' ? 'checked' : '' }}>
                                Pekerjaan B3 & Limbah B3
                            </label>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp8" {{ $wp->kp8 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Penanaman Tiang
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp9" {{ $wp->kp9 == 'on' ? 'checked' : '' }}>
                                Pekerjaan Konstruksi
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="kp10" {{ $wp->kp10 == 'on' ? 'checked' : '' }}>
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
                                <input type="checkbox" name="p1" {{ $wp->p1 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan Pembangkit
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p2" {{ $wp->p2 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan Kubikel
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p3" {{ $wp->p3 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan APP Pelanggan
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p4" {{ $wp->p4 == 'on' ? 'checked' : '' }}>
                                Prosedur Lainnya, sebutkan
                            </label>
                        </div>

                        @if ($wp->p4 == 'on')
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" readonly  value="{{ $wp->p4_lainnya }}" class="form-control">
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p5" {{ $wp->p5 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan Disribusi
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p6" {{ $wp->p6 == 'on' ? 'checked' : '' }}>
                                PDKB TM
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p7" {{ $wp->p7 == 'on' ? 'checked' : '' }}>
                                Pengoperasian Jaringan Baru
                            </label>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p8" {{ $wp->p8 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan Transmisi
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p9" {{ $wp->p9 == 'on' ? 'checked' : '' }}>
                                Pemeliharaan Gardu Induk
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="p10" {{ $wp->p10 == 'on' ? 'checked' : '' }}>
                                Bongkar Pasang Tiang Beton
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
                <h4>E. LAMPIRAN IZIN KERJA (WAJIB DILAMPIRKAN)</h4>
            </div>
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" {{ $wp->workPermitHirarc != null ? 'checked' : '' }}>
                                @if($wp->workPermitHirarc == null)
                                <a id="c_hirarc" href="#">Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (IBPPR)</a>
                                @else
                                <a target="_blank" href="{!! url($wp->workPermitHirarc->hirarc->file) !!}">Identifikasi Bahaya, Penilaian dan Pengendalian Risiko (IBPPR)</a>
                                @endif
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="l2" name="l2" {{ $wp->jsa != null ? 'checked' : '' }}>
                                @if($wp->jsa != null)
                                <a href="{{ url('jsa?wp_id='.$wp->id) }}">Job Safety Analysis (JSA)</a>
                                @else
                                <a href="{{ url('jsa/form?wp_id='.$wp->id) }}">Job Safety Analysis (JSA)</a>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" {{ $wp->workPermitProsedurKerja != null ? 'checked' : '' }}>
                                @if($wp->workPermitProsedurKerja == null)
                                <a id="c_prosedur_kerja" href="#">Prosedur Kerja</a>
                                @else
                                <a target="_blank" href="{!! url($wp->workPermitProsedurKerja->prosedurKerja->file) !!}">Prosedur Kerja</a>
                                @endif
                            </label>
                        </div>
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="l4" name="l4" {{ $wp->jsa != null ? 'checked' : '' }}>
                                Sertifikasi Kompetensi Pekerja
                            </label>
                        </div>

                        @if($wp->jsa != null)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="l5"  {{ $wp->jsa != null ? 'checked' : '' }}>
                                <a href="{{ url('pembagian-tugas-apd/form?jsa_id='.$wp->jsa->id) }}">Kondisi Kesiapan Personil, APD dan Pembagian Tugas</a>
                            </label>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        
                        
                        {{-- <div class="checkbox">
                            <label>
                                <input type="checkbox" id="l4" name="l4" {{ $wp->l4 == 'on' ? 'checked' : '' }}>
                                Sertifikasi Kompetensi Pekerja
                            </label>
                        </div> --}}
                    </div>
                </div>

                <div class="col-md-12">
                    <p><b>Keterangan : Form Izin Kerja tidak dapat disetujui jika salah satu lampiran tidak ada</b></p>
                </div>
            </div>
            <div class="box-footer">
                @if(Auth::user()->status == 'Admin' || $wp->users_id == Auth::id())
                <a class="btn btn-warning" href="{{ url('work-permit/form-edit?id='.$wp->id) }}"><i class="fa fa-edit"></i> Edit</a>
                @endif
                <a class="btn btn-danger" href="{{ url('work-permit/print?id='.$wp->id) }}"><i class="fa fa-print"></i> Print</a>
                <button class="btn btn-success btn-send-wa" data-id="{{ $wp->id }}"><i class="fa fa-whatsapp-o"></i> Send Whatsapp</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <b><i class="fa fa-check"></i> Disetujui oleh Manager</b>
            </div>
            <div class="box-body text-center">
                @if ($wp->wpApproval->man_app == NULL)
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @else
                {!! QrCode::size(100)->generate('Approved by manager'); !!}
                @endif
            </div>
            <div class="box-footer">
                @if ($wp->wpApproval->man_app == NULL && Auth::user()->status == 'Manajer' && $wp->wpApproval->spv_app != NULL)
                <button class="btn btn-sm btn-success btn-approve" data-kategori="man_app">Approve</button>
                <button class="btn btn-sm btn-danger btn-reject pull-right" data-kategori="man_reject">Koreksi</button>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <b><i class="fa fa-check"></i> Diperiksa oleh Supervisor</b>
            </div>
            <div class="box-body text-center">
                @if ($wp->wpApproval->spv_app == NULL)
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @else
                {!! QrCode::size(100)->generate('Approved by supervisor'); !!}
                @endif
            </div>
            <div class="box-footer">
                @if ($wp->wpApproval->ppk3_app != NULL && $wp->wpApproval->spv_app == NULL && Auth::user()->level == 3 && $wp->bidang == Auth::user()->bidang && Auth::user()->usersUnit != NULL && $wp->unit_id == Auth::user()->usersUnit->unit_id)
                <button class="btn btn-sm btn-success btn-approve" data-kategori="spv_app">Approve</button>
                <button class="btn btn-sm btn-danger btn-reject pull-right" data-kategori="spv_reject">Koreksi</button>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <b><i class="fa fa-check"></i> Diperiksa oleh Pejabat Pelaksana K3</b>
            </div>
            <div class="box-body text-center">
                @if ($wp->wpApproval->ppk3_app == NULL)
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @else
                {!! QrCode::size(100)->generate('Approved by pejabat pelaksana K3'); !!}
                @endif
            </div>
            <div class="box-footer">
                @if ($wp->wpApproval->ppk3_app == NULL && Auth::user()->level == 2 && Auth::user()->usersUnit != NULL 
                && $wp->unit_id == Auth::user()->usersUnit->unit_id && $wp->reject == 0 && $wp->jsa != NULL && $wp->jsa->review == 'JSA telah di review dan disetujui')
                <button class="btn btn-sm btn-success btn-approve" data-kategori="ppk3_app">Approve</button>
                @endif

                @if ($wp->wpApproval->ppk3_app == NULL && Auth::user()->level == 2 && Auth::user()->usersUnit != NULL && $wp->unit_id == Auth::user()->usersUnit->unit_id && $wp->reject == 0 && $wp->jsa != NULL && $wp->jsa->review == 'JSA telah di review dan disetujui')
                <button class="btn btn-sm btn-danger btn-reject pull-right" data-kategori="ppk3_reject">Koreksi</button>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="box">
            <div class="box-header">
                <b><i class="fa fa-check"></i> Diajukan Oleh Pelaksana Pekerjaan</b>
            </div>
            <div class="box-body text-center">
                @if($wp->submit == 0)
                <img src="{!! asset('notapprove.png') !!}" width="40%" alt="">
                @else
                {!! QrCode::size(100)->generate('submitted by '.$wp->users->name); !!}
                @endif
            </div>
            <div class="box-footer">
                @if (Auth::id() == $wp->users_id && $wp->submit == 0 && $wp->workPermitHirarc != null && $wp->jsa != null && $wp->workPermitProsedurKerja != null)
                <button  class="btn btn-sm btn-success form-control btn-submit-wp" data-id="{{ $wp->id }}">Submit</button>
                @endif

                @if ($wp->reject == 1)
                <button  class="btn btn-sm btn-success form-control btn-resubmit" data-id="{{ $wp->id }}">Re Submit</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script src="{!! asset('pdfobject.js') !!}"></script>


<script type="text/javascript">

    $(document).on("click", ".btn-resubmit", function (e) {
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
                    url: "{!! url('work-permit/resubmit?id=') !!}" + id,
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

    $(document).on("click", ".btn-submit-wp", function (e) {
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
                    url: "{!! url('work-permit/submit?id=') !!}" + id,
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

    //pk timer
    function startTimer(duration, display) {
        var timeleft = duration;
        var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            document.getElementById(display).innerHTML = "Mengerti";
            $('#'+display).removeAttr('disabled');
        } else {
            document.getElementById(display).innerHTML = timeleft + " seconds remaining";
        }
        timeleft -= 1;
        }, 1000);
    }

    // Prosedur Kerja
    $(document).on('click','.btn-pk-ok', function(){
        $.ajax({
            type : 'post',
            url : "{!! url('work-permit/pk-select') !!}",
            data : {
                wp_id : $('#pk_wp_id').val(),
                pk_id : $('#pk_file_select').val()
            },
            success : function(r){
                if (r == 'success') {
                    Swal.fire(
                    'Yeaa !',
                    'Simpan data berhasil !',
                    'success'
                    ).then(function(){
                        location.reload()
                    });
                }
            }

        })
        // $('#view-hirarc-modal').modal('hide')
    })

    function showPkSave() {
        document.getElementById('btn-save-pk').style.visibility = 'visible';
    }

    $(document).on('click','#c_prosedur_kerja',function(e) {
        e.preventDefault()
        // document.getElementById('btn-save-pk').style.visibility = 'hidden';
        

        // setTimeout(showPkSave, 20000)

        $('#view-pk-modal').modal('show')
    });

    $(document).on('click','#btn-upload-pk', function(){
        $('#add-pk-modal').modal('show')
        // $('#add_jenis_pekerjaan').val($('#select_jp').val())
    })

    $('#form_pk_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('prosedur-kerja/create') !!}",
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
                    $('#add-pk-modal').modal('hide')
                    loadPkFile($('#pk_select_jp').val())
                }
            }
        })
    })
    
    $("#l3").change(function() {
        if(this.checked) {
            $('#view-pk-modal').modal('show')
        }
    });
    
    $(document).on('change','#pk_select_jp', function(){
        loadPkFile($('#pk_select_jp').val())
    })
    
    $(document).on('change','#pk_file_select', function(){
        var id = $('#pk_file_select').val()
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('prosedur-kerja/get-by-id?id=') }}"+id,
            success : function(r){
                hidePleaseWait()
                $('#pk_id').val(r.id)
                var link = "{!! url('') !!}/"+r.file
                // console.log(link)
                document.getElementById("pk_iframe").src=link;

                $('#btn-save-pk').attr('disabled','disabled')
                $('#btn-save-pk').text('');
                var time = 5
                startTimer(time, "btn-save-pk");
            }
        })
    })
    
    function loadPkFile(jenis_pekerjaan){
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('prosedur-kerja/get-by-jp?jp=') }}"+jenis_pekerjaan,
            success : function(r){
                hidePleaseWait()
                $('#pk_file_select').empty()
                $('#pk_file_select').append('<option value=""></option>')
                $.each(r.prosedur_kerja, function(i, d){
                    $('#pk_file_select').append(
                    '<option value="'+d.id+'">'+'('+d.ket+') '+d.file+'</option>'
                    )
                })
            }
        })
    }

    // HIRARC
    $(document).on('click','.btn-hirarc-ok', function(){
        $.ajax({
            type : 'post',
            url : "{!! url('work-permit/hirarc-select') !!}",
            data : {
                wp_id : $('#hirarc_wp_id').val(),
                hirarc_id : $('#hirarc_file_select').val()
            },
            success : function(r){
                if (r == 'success') {
                    Swal.fire(
                    'Yeaa !',
                    'Simpan data berhasil !',
                    'success'
                    ).then(function(){
                        location.reload()
                    });
                }
            }

        })
        // $('#view-hirarc-modal').modal('hide')
    })

    $(document).on('click','#btn-upload-hirarc', function(){
        $('#add-hirarc-modal').modal('show')
        // $('#add_jenis_pekerjaan').val($('#select_jp').val())
    })

    $('#form_hirarc_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('hirarc/create') !!}",
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
                    $('#add-hirarc-modal').modal('hide')
                    loadHirarcFile($('#hirarc_select_jp').val())
                }
            }
        })
    })

    function showHirarcSave() {
        document.getElementById('btn-save-hirarc').style.visibility = 'visible';
    }

    $(document).on('click','#c_hirarc',function(e) {
        e.preventDefault()
        // document.getElementById('btn-save-hirarc').style.visibility = 'hidden';
        

        // setTimeout(showHirarcSave, 20000)

        $('#view-hirarc-modal').modal('show')
    });
    
    $(document).on('change','#hirarc_select_jp', function(){
        loadHirarcFile($('#hirarc_select_jp').val())
    })
    
    $(document).on('change','#hirarc_file_select', function(){
        var id = $('#hirarc_file_select').val()
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('hirarc/get-by-id?id=') }}"+id,
            success : function(r){
                hidePleaseWait()
                $('#hirarc_id').val(r.id)
                var link = "{!! url('') !!}/"+r.file
                // console.log(link)
                document.getElementById("hirarc_iframe").src=link;

                $('#btn-save-hirarc').attr('disabled','disabled')
                var time = 5
                // display = document.querySelector('#btn-save-hirarc');
                startTimer(time, 'btn-save-hirarc');
            }
        })
    })
    
    function loadHirarcFile(jenis_pekerjaan){
        showPleaseWait();
        $.ajax({
            type : 'get',
            url : "{{ url('hirarc/get-by-jp?jp=') }}"+jenis_pekerjaan,
            success : function(r){
                console.log(r)
                hidePleaseWait()
                $('#hirarc_file_select').empty()
                $('#hirarc_file_select').append('<option value=""></option>')
                $.each(r.hirarc, function(i, d){
                    $('#hirarc_file_select').append(
                    '<option value="'+d.id+'">'+'('+d.ket+') '+d.file+'</option>'
                    )
                })
            }
        })
    }
    
    $(document).on('click','.btn-send-wa', function(){
        // alert($(this).data('id'))
        window.location = "{{ url('work-permit/send-wa?id=') }}"+$(this).data('id')
    })
    
    $(":checkbox").on("click", false);
    
    
    $(document).on('click','.btn-approve', function(){
        $('#kategori').val($(this).data('kategori'))
        $('#add-app-modal').modal('show')
    })
    
    $('#form_app_add').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('work-permit/approve') !!}",
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

    $(document).on('click','.btn-reject', function(){
        $('#r_kategori').val($(this).data('kategori'))
        $('#reject-modal').modal('show')
    })
    
    $('#form_reject').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('work-permit/reject') !!}",
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
</script>

@endsection