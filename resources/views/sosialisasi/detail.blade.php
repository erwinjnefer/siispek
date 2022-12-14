@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
<style>
    .selected {
            background-color: gray;

        }
</style>
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Sosialisasi
        <small>Detail</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{!! url('sosialisasi') !!}"><i class="fa fa-share-alt"></i> Sosialisasi</a></li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
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
                        <input type="hidden" name="sosialisasi_id" value="{{ $sosialisasi->id }}">
                        <input type="hidden" name="kategori[]" value="Foto Sosialisasi">
                        <div class="form-group">
                            <label for="">Foto Sosialisasi</label>
                            <input type="file" class="form-control" required name="foto[]" accept="image/*">
                        </div>
                        
                        <input type="hidden" name="kategori[]" value="Foto Lokasi">
                        <div class="form-group">
                            <label for="">Foto Lokasi</label>
                            <input type="file" class="form-control" required name="foto[]" accept="image/*">
                        </div>
                        
                        <input type="hidden" name="kategori[]" value="Foto Surat Pemberitahuan">
                        <div class="form-group">
                            <label for="">Foto Surat Pemberitahuan</label>
                            <input type="file" class="form-control" required name="foto[]" accept="image/*">
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

    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1">Tanggal</label>
    
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ date('d-m-Y', strtotime($sosialisasi->date)) }}" readonly  placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1">Judul</label>
    
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ $sosialisasi->judul }}" readonly  placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1">Lokasi</label>
    
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ $sosialisasi->lokasi }}" readonly  placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1">Koordinat</label>
    
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ $sosialisasi->koordinat }}" readonly  placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1">Pemilik</label>
    
                        <div class="col-sm-10">
                            <input type="email" class="form-control" value="{{ $sosialisasi->pemilik }}" readonly  placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-1"></label>
    
                        <div class="col-sm-2">
                            <button data-toggle="modal" data-target="#add-foto-modal" class="btn btn-success">Upload Foto</button>
                        </div>
                    </div>


                </div>
            </div>
            <div class="box-footer">
                <ul class="mailbox-attachments clearfix">
                    @foreach ($sosialisasi->sosialisasiFoto as $foto)

                    <li>
                        <span class="mailbox-attachment-icon has-img"><img src="{!! url($foto->foto) !!}" style="width: 100%;height: 180px;" alt="Attachment"></span>
                        <span>{!! $foto->kategori !!}</span>
                        <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name badge bg-red btn-del-foto" data-id={{ $foto->id }}><span>Delete</span></a>
                        </div>
                    </li>
                    @endforeach
                   
                </ul>

                <br>
                @if ($sosialisasi->submit == 0 && ($sosialisasi->users_id == Auth::id() || Auth::user()->status == 'Admin'))
                <button  class="btn btn-sm btn-success pull-right btn-submit-sos" data-id="{{ $sosialisasi->id }}">Submit</button>
                @else
                <a href="{!! url('sosialisasi') !!}" class="btn btn-primary pull-right"><i class="fa fa-arrow-left"></i> Back</a>
                @endif

            </div>
        </div>
    
    </div>
</div>
    
@endsection
@section('js')
    <script>

$(document).on("click", ".btn-submit-sos", function (e) {
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
                    url: "{!! url('sosialisasi/submit?id=') !!}" + id,
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

        $('#form_foto_add').on('submit', function (e) {
            e.preventDefault()
            showPleaseWait()
            $.ajax({
                type: 'post',
                url: "{!! url('sosialisasi/upload-foto') !!}",
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
                        url: "{!! url('sosialisasi/delete-foto?id=') !!}" + id,
                        success: function (r) {
                            console.log(r)
                            hidePleaseWait()
                            if (r == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
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
    </script>
@endsection