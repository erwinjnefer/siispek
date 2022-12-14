@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Pegawai Vendor
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pegawai Vendor</li>
        <li><a href="#" data-toggle="modal"data-target="#add-pegawai-modal"><i class="fa fa-user-plus"></i> Create Pegawai</a></li>
    </ol>
</section>
@endsection
@section('content')
<div class="modal fade" id="add-pegawai-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_pegawai_add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Pegawai</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                    <div class="form-group">
                        <label for="">Nama Pegawai</label>
                        <input type="text" class="form-control" name="nama">
                    </div>

                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan</label>
                        <select class="form-control" name="jabatan">
                            <option>Pengawas K3</option>
                            <option>Pengawas Pekerjaan</option>
                            <option>Pelaksana Pekerjaan</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" class="form-control" name="no_wa">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Jenis.Identitas</label>
                                <select class="form-control" name="jenis_identitas">
                                    <option>KTP</option>
                                    <option>SIM</option>
                                    <option>NPWP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">No.Identitas</label>
                                <input type="text" class="form-control" name="no_identitas">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Sertifikasi</label>
                        <select class="form-control" name="sertifikasi">
                            <option>Ya</option>
                            <option>Tidak</option>
                        </select>
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

<div class="modal fade" id="edit-pegawai-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_pegawai_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Pegawai</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id">
                    <div class="form-group">
                        <label for="">Nama Pegawai</label>
                        <input type="text" class="form-control" id="e_nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" id="e_username" name="username" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="e_password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="">Jabatan</label>
                        <select class="form-control" id="e_jabatan" name="jabatan">
                            <option>Pengawas K3</option>
                            <option>Pengawas Pekerjaan</option>
                            <option>Pelaksana Pekerjaan</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" class="form-control" id="e_no_wa" name="no_wa">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Jenis.Identitas</label>
                                <select class="form-control" id="e_jenis_identitas" name="jenis_identitas">
                                    <option>KTP</option>
                                    <option>SIM</option>
                                    <option>NPWP</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">No.Identitas</label>
                                <input type="text" class="form-control" id="e_no_identitas" name="no_identitas">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Sertifikasi</label>
                        <select class="form-control" id="e_sertifikasi" name="sertifikasi">
                            <option>Ya</option>
                            <option>Tidak</option>
                        </select>
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
                    <input type="hidden" id="p_id" name="pegawai_id">
                    <div class="form-group">
                        <label for="">Jenis</label>
                        <input type="text" class="form-control" name="jenis" required>
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




<div class="row">

    <div class="col-md-3">
        <div class="box box-default">
            <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{!! asset('showimage.png') !!}" alt="User profile picture">

            <h3 class="profile-username text-center">{!! $vendor->name !!}</h3>

            <p class="text-muted text-center">Vendor</p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                <b>Pegawai</b> <a class="pull-right">{!! count($pegawai) !!}</a>
                </li>
                {{-- <li class="list-group-item">
                <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                <b>Friends</b> <a class="pull-right">13,287</a> --}}
                </li>
            </ul>

            </div>
            <!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <button class="btn btn-primary form-control"  data-toggle="modal"data-target="#add-pegawai-modal"><i class="fa fa-pencil"></i> CREATE PEGAWAI</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                </div>
            </div>
        </div>

        <div class="box box-default">
            <div class="box-header">
                <i class="fa fa-book"></i> <b>DAFTAR PEGAWAI</b>
                <div class="box-tools">
                    {{-- <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                        data-target="#add-pegawai-modal">
                        <i class="fa fa-plus-circle"></i> Create Pegawai
                    </button> --}}
                </div>
            </div>
            <div class="box-body">
                <table id="dataTable" width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Jabatan</th>
                            <th>Nomor Whatsapp</th>
                            <th>No Identitas</th>
                            <th>Sertifikat</th>
                            <th>File Sertifikat</th>
                            <th style="text-align: center;">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($pegawai as $p)
                        <tr role="row" class="odd">
                            <td>{{ $no++ }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->username }}</td>
                            <td>{{ $p->jabatan }}</td>
                            <td>{{ $p->no_wa }}</td>
                            <td>{{ $p->jenis_identitas.'.'.$p->no_identitas }}</td>
                            <td align="center">{{ $p->sertifikasi }}</td>
                            <td>
                                <a href="#" data-id="{{ $p->id }}" class="btn-upload"><span class="badge bg-green"><i class="fa fa-cloud-upload"></i> Upload Sertifikat</span></a>
                                <br>
                                @foreach ($p->sertifikat as $s)
                                    <br>
                                    <a href="{!! url($s->file) !!}"><span class="badge bg-blue"><i class="fa fa-file"></i> {!! $s->jenis !!}</span></a>
                                @endforeach
                            </td>
                            <td align="center">
                                <a href="#" data-id="{!! $p->id !!}" data-nama="{!! $p->nama !!}" data-jabatan="{!! $p->jabatan !!}" data-no_identitas="{!! $p->no_identitas !!}" 
                                    data-jenis_identitas="{!! $p->jenis_identitas !!}" data-no_wa="{!! $p->no_wa !!}" data-sertifikasi="{!! $p->sertifikasi !!}" class="btn btn-primary btn-sm btn-edit"><i
                                        class="fa fa-pencil"></i> Edit</a>

                                <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $p->id !!}"><i
                                        class="fa fa-trash-o"></i> Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script src="{!! asset('/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
<script type="text/javascript">
    var mytable = $('#dataTable').DataTable({
        sDom : 'lrtip',
        "info" : false,
        "lengthChange" : false,
        "pageLength" : 100,
        "scrollX" : true,
    })
    
    $('#key_search').on( 'keyup', function () {
        mytable.search( this.value ).draw();
    });

    $(document).on('click','.btn-upload', function(e){
        e.preventDefault()
        $('#p_id').val($(this).data('id'))
        $('#add-sertifikat-modal').modal('show')
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

    $(document).on('click', '.btn-edit', function () {

        $('#e_id').val($(this).data('id'))
        $('#e_nama').val($(this).data('nama'))
        $('#e_jabatan').val($(this).data('jabatan'))
        $('#e_no_wa').val($(this).data('no_wa'))
        $('#e_no_identitas').val($(this).data('no_identitas'))
        $('#e_jenis_identitas').val($(this).data('jenis_identitas'))
        $('#e_sertifikasi').val($(this).data('sertifikasi'))

        $('#edit-pegawai-modal').modal('show')
    })



    $('#form_pegawai_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('pegawai-vendor/create') !!}",
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

    $('#form_pegawai_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('pegawai-vendor/update') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                if (r == 'success') {
                    
                    Swal.fire(
                        'Success !',
                        'Edit data berhasil !',
                        'success'
                    ).then(function(){
                        location.reload()
                    })
                    // loadVendor()
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
            url: "{!! url('pegawai-vendor/delete?id=') !!}"+id,
            success: function (r) {
                console.log(r)
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
</script>



@endsection
