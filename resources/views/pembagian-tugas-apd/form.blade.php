@extends('layouts.master')
@section('css')
<link rel="stylesheet"
    href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css"
  />
<style>
    .scroll {
        overflow-x: auto;
        /* white-space: nowrap; */
    }
</style>
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Kondisi Kesiapan, APD dan Pembagian Tugas
        <small>Form</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{!! url('work-permit/detail?id='.$jsa->work_permit_id) !!}"><i class="fa fa-book"></i> Work
                Permit</a></li>
        <li class="active">Form</li>
    </ol>
</section>

@endsection
@section('content')
<div class="row">
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_checklist" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Input checklist</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="jp_id" name="id">
                        <div class="form-group">
                            <label for="">Nama Pelaksana</label>
                            <input type="text" readonly class="form-control" id="nama_pelaksana">
                        </div>

                        <div class="form-group p_kondisi" data-content="Kondisi jasmani, Rohani, Disiplin dan (Kemampuan teknis dan  keterampilan)" rel="popover" data-placement="top" data-original-title="Meliputi" data-trigger="hover">
                            <label for="">Kondisi</label>
                            <select class="form-control" name="kondisi">
                                <option>OK</option>
                                <option>NO</option>
                            </select>
                        </div>

                        <label for="">APD & Alat K3</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd1">
                                        Helm pengaman
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd2">
                                        Kacamata tahan silau
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd3">
                                        Masker anti racun
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd4">
                                        Sabuk pengaman/Full
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd5">
                                        Sarung tangan kulit
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd6">
                                        Sarung tangan tahan tegangan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd7">
                                        Sepatu panjat
                                    </label>
                                </div>
                                
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd8">
                                        Sepatu tahan air
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd9">
                                        Sepatu tahan tegangan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd10">
                                        Tongkat (Stick) pentanahan
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd11">
                                        Kabel pentanahan fleksibel
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="apd12">
                                        Detektor (tester) tegangan
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="">Tugas</label>
                            <textarea class="form-control" name="tugas" rows="3"></textarea>
                        </div>
                        
                        
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header"></div>
            <div class="box-body scroll">

                <table class="table table-bordered">
                    <tr style="background: #D2D6DE">
                        <th rowspan="2" width="1%">NO</th>
                        <th rowspan="2" width="5%">NAMA PELAKSANA</th>
                        <th rowspan="2" width="2%">KONDISI</th>
                        <th colspan="12" width="15%" class="text-center">APD</th>
                        <th rowspan="2" width="5%">PEMBAGIAN TUGAS</th>
                    </tr>
                    <tr style="background: #D2D6DE">
                        <th class="text-center">Helm Pengaman</th>
                        <th class="text-center">Kacamata tahan silau</th>
                        <th class="text-center">Masker anti racun</th>
                        <th class="text-center">Sabuk pengaman/Full</th>
                        <th class="text-center">Sarung tangan kulit</th>
                        <th class="text-center">Sarung tangan tahan tegangan</th>
                        <th class="text-center">Sepatu panjat</th>
                        <th class="text-center">Sepatu tahan air</th>
                        <th class="text-center">Sepatu tahan tegangan</th>
                        <th class="text-center">Tongkat (Stick) pentahanan</th>
                        <th class="text-center">Kabel pentanahan fleksibel</th>
                        <th class="text-center">Detektor (tester) tegangan</th>
                    </tr>
                    @php
                        $no = 1;
                    @endphp
                    @foreach($jsa->jsaPegawai as $jp)
                        <tr>
                            <td>{!! $no ++ !!}</td>
                            <td><a href="#" class="item-edit" data-id="{{ $jp->id }}"
                                    data-nama="{{ $jp->pegawai->nama }}"><span class="badge bg-green">{!!
                                        $jp->pegawai->nama !!}</span></a></td>
                            <td>{!! $jp->kondisi !!}</td>
                            <td align="center">{!! $jp->apd1 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd2 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd3 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd4 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd5 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd6 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd7 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd8 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd9 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd10 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd11 == 'on' ? '☑' : '' !!}</td>
                            <td align="center">{!! $jp->apd12 == 'on' ? '☑' : '' !!}</td>
                            <td>{!! $jp->tugas !!}</td>
                        </tr>
                    @endforeach
                    
                </table>
            </div>
            <div class="box-footer">
                {{-- <button type="submit" class="btn btn-primary btn-save">Simpan</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>

    $('.p_kondisi').popover();

    

    $(document).on('click','.item-edit', function(e){
        e.preventDefault()
        $('#edit-modal').modal('show')
        $('#jp_id').val($(this).data('id'))
        $('#nama_pelaksana').val($(this).data('nama'))
    })

    $('#form_checklist').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('pembagian-tugas-apd/save') !!}",
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
                    ).then(function () {
                        location.reload()
                    })
                }
            }
        })
    })
</script>
@endsection