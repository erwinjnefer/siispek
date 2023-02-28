@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .selected {
            background-color: rgb(224, 215, 131);

        }
</style>
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Sosialisasi
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-share-alt"></i> Sosialisasi</li>
        <li></li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
    <div class="modal fade" id="create-sosialisasi-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_create_sosialisasi" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Create Sosialisasi</h4>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" readonly name="date" class="form-control" id="date" required/>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <option>Forum</option>
                                <option>Personal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" readonly name="judul" value="Sosialisasi Bahaya Listrik Masyarakat Umum" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <textarea rows="5" name="lokasi" class="form-control" required/>{!! "Kelurahan :\nKecamatan :\n\nInformasi Tambahan : " !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Coordinate Format (Lat , Long) <b class="text-danger"> Cth : -8.5773565 , 116.0815247</b></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="koordinat" name="koordinat" required>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-sm btn-success form-control btn-get-coordinate">Get Coordinate</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Pemilik</label>
                            <input type="text" name="pemilik" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label for="">Id Pel / Nomor Tiang</label>
                            <input type="text" name="id_pel_no_tiang" class="form-control"/>
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
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#create-sosialisasi-modal">Create</button>
                            <button class="btn btn-danger btn-delete">Delete</button>
                            <a href="{!! url('sosialisasi/map-gardu') !!}" class="btn btn-success btn-gardu"><i class="fa fa-map"></i> Map Gardu</a>
                            <a href="{!! url('sosialisasi/map') !!}" class="btn btn-info btn-map"><i class="fa fa-map"></i> Map Sosialisasi</a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="dataTable" width="100%" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Kategori</th>
                                    <th>Judul Sosialisasi</th>
                                    <th>Lokasi</th>
                                    <th>Pemilik</th>
                                    <th>ID Pel / Nomor Tiang</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($sosialisasi as $s)
                                <tr>
                                    <td data-id="{!! $s->id !!}" width="1%">{!! $no ++ !!}</td>
                                    <td width="5%">{!! date('d-m-Y', strtotime($s->date)) !!}</td>
                                    <td width="10%">{!! $s->kategori !!}</td>
                                    <td width="10%">{!! $s->judul !!}</td>
                                    <td width="20%">
                                        <a href="{{ url('sosialisasi/detail?id='.$s->id) }}">{!! str_replace("\n","<br>", $s->lokasi)  !!}</a><br>
                                        <a href="{{ url('sosialisasi/sos-map?id='.$s->id) }}" target="_blank"><span class="badge bg-blue"><i class="fa fa-map"></i> {{ $s->koordinat }}</span></a>
                                    </td>
                                    <td width="5%">{!! $s->pemilik !!}</td>
                                    <td width="5%">{!! $s->id_pel_no_tiang !!}</td>
                                    {{-- <td width="5%"></td> --}}
                                    <td width="5%">{{ $s->users->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{!! asset('/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
<script type="text/javascript">

     $('#date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    })
    var sosialisasi_id = null;
    
    var mytable = $('#dataTable').DataTable({
        sDom : 'lrtip',
        "info" : false,
        "lengthChange" : false,
        "scrollX" : true,
    })

    $('#dataTable tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            sosialisasi_id = null
        } else {
            mytable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var tr = $(this).closest('tr');
            sosialisasi_id = tr.children("td:eq(0)").attr('data-id')
        }
    });

    
    $('#key_search').on( 'keyup', function () {
        mytable.search( this.value ).draw();
    });

    $('#form_create_sosialisasi').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('sosialisasi/create') !!}",
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
                        location.reload()
                    })
                }
            }
        })
    })

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault()
        if (sosialisasi_id == null) {
            Swal.fire(
                'Oops !',
                'Tidak ada data yang dipilih !',
                'error'
            )
        } else {
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
                    $.ajax({
                        type: 'get',
                        url: "{!! url('sosialisasi/delete?id=') !!}" + sosialisasi_id,
                        success: function (r) {
                            console.log(r)
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
        }

    })


    $(document).on('click','.btn-get-coordinate', function(e){
        e.preventDefault()
        getLocation()
    })
    
    function showLocation(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        $('#koordinat').val(latitude+','+longitude)
    }
    
    function errorHandler(err) {
        if(err.code == 1) {
            alert("Error: Access is denied!");
        }else if( err.code == 2) {
            alert("Error: Position is unavailable!");
        }
    }

    function getLocation(){
        
        if(navigator.geolocation){
            // timeout at 60000 milliseconds (60 seconds)
            var options = {timeout:60000};
            navigator.geolocation.getCurrentPosition(showLocation, 
            errorHandler,
            options);
        }else{
            alert("Sorry, browser does not support geolocation!");
        }
    }
    
</script>
@endsection