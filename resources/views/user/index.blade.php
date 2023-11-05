@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection

@section('content-header')
<section class="content-header">
    <h1>
        Users
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>
@endsection
@section('content')

<div class="modal fade" id="input-no-wa-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_input_no_wa">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Input No WA</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="wa_id" name="id">
                    <div class="form-group">
                        <label for="">Nama User</label>
                        <input type="text" readonly class="form-control" id="wa_name">
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="">No WA</label>
                        <input type="text" class="form-control" id="wa_no_wa" name="no_wa">
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

<div class="modal fade" id="add-user-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_user_add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Users</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama User</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option>Admin</option>
                                <option>Manajer</option>
                                <option>General Manajer</option>
                                <option>Senior Manajer</option>
                                <option>Manajer K3LKAM</option>
                                <option>Asman K3LKAM</option>
                                <option>Officer K3</option>
                                <option>Manajer Bidang</option>
                                <option>Pejabat Pelaksana K3</option>
                                <option>PJ Ops</option>
                                <option>Manajer Bagian Keuangan dan Umum</option>
                                <option>Manajer Bagian Konstruksi</option>
                                <option>Manajer Bagian Jaringan</option>
                                <option>Manajer Bagian Pemasaran dan Pelayanan Pelanggan</option>
                                <option>Manajer Bagian Transaksi Energi</option>
                                <option>Manajer Bagian Perencanaan</option>
                                <option>Supervisor Teknik</option>
                                <option>Supervisor Pelayanan Pelanggan</option>
                                <option>Supervisor Transaksi Energi</option>
                                <option>Pejabat K3L dan KAM</option>
                                <option>Pengawas Manuver</option>
                                <option>Vendor</option>
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




<div class="modal fade" id="edit-user-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_user_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit User</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="">Nama User</label>
                            <input type="text" class="form-control" id="e_name" name="name">
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" id="e_email" name="email">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="e_status" class="form-control">
                                <option>Admin</option>
                                <option>Manajer</option>
                                <option>General Manajer</option>
                                <option>Senior Manajer</option>
                                <option>Manajer K3LKAM</option>
                                <option>Asman K3LKAM</option>
                                <option>Officer K3</option>
                                <option>Pejabat Pelaksana K3</option>
                                <option>PJ Ops</option>
                                <option>Manajer Bidang</option>
                                <option>Manajer Bagian Keuangan dan Umum</option>
                                <option>Manajer Bagian Konstruksi</option>
                                <option>Manajer Bagian Jaringan</option>
                                <option>Manajer Bagian Pemasaran dan Pelayanan Pelanggan</option>
                                <option>Manajer Bagian Transaksi Energi</option>
                                <option>Manajer Bagian Perencanaan</option>
                                <option>Supervisor Teknik</option>
                                <option>Supervisor Pelayanan Pelanggan</option>
                                <option>Supervisor Transaksi Energi</option>
                                <option>Pejabat K3L dan KAM</option>
                                <option>Pengawas Manuver</option>
                                <option>Vendor</option>
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
    
    <div class="modal fade" id="add-user-unit-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_user_unit_add">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pointing Unit</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="user_unit_id" name="user_id">
                        
                        <div class="form-group">
                            <label for="">Unit</label>
                            <select name="unit_id" class="form-control">
                                @foreach ($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @endforeach
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
    
    <div class="modal fade" id="edit-user-unit-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_user_unit_edit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Pointing Unit</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="e_user_unit_id" name="id">
                        
                        <div class="form-group">
                            <label for="">Unit</label>
                            <select name="unit_id" id="e_unit_id" class="form-control">
                                @foreach ($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @endforeach
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

    <div class="modal fade" id="validasi-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_validasi">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Validasi</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="v_user_id" name="id">
                        
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control">
                                <option value=""></option>
                                <option>Admin</option>
                                <option>Manajer</option>
                                <option>General Manajer</option>
                                <option>Senior Manajer</option>
                                <option>Manajer K3LKAM</option>
                                <option>Asman K3LKAM</option>
                                <option>Officer K3</option>
                                <option>Pejabat Pelaksana K3</option>
                                <option>PJ Ops</option>
                                <option>Manajer Bidang</option>
                                <option>Manajer Bagian Keuangan dan Umum</option>
                                <option>Manajer Bagian Konstruksi</option>
                                <option>Manajer Bagian Jaringan</option>
                                <option>Manajer Bagian Pemasaran dan Pelayanan Pelanggan</option>
                                <option>Manajer Bagian Transaksi Energi</option>
                                <option>Manajer Bagian Perencanaan</option>
                                <option>Supervisor Teknik</option>
                                <option>Supervisor Pelayanan Pelanggan</option>
                                <option>Supervisor Transaksi Energi</option>
                                <option>Pejabat K3L dan KAM</option>
                                <option>Pengawas Manuver</option>
                                <option>Vendor</option>
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
    <div class="modal fade" id="edit-bidang-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_bidang">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Edit Bagian & Level</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="ub_id" name="id">
                        
                        <div class="form-group">
                            <label for="">Bagian</label>
                            <select name="bidang" id="ub_bidang" class="form-control">
                                <option value=""></option>
                                <option>Keuangan dan Umum</option>
                                <option>Konstruksi</option>
                                <option>Jaringan</option>
                                <option>Pemasaran dan Pelayanan Pelanggan</option>
                                <option>Transaksi Energi</option>
                                <option>Perencanaan</option>
                                <option>Teknik</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level" id="ub_level" class="form-control">
                                <option value=""></option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
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
    
    <div class="row">
        <div class="col-md-12">
            
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary form-control" data-toggle="modal" data-target="#add-user-modal">Create User</button>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            
                            
                            
                            <table id="dataTable" class="table table-bordered table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Users</th>
                                        <th>Email</th>
                                        <th>Nomor WA</th>
                                        <th>Status</th>
                                        <th>Bagian / Level</th>
                                        <th>User Unit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($user as $user)
                                    <tr role="row" class="odd">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->no_wa != null)
                                            <a href="#" class="btn-input-no-wa" data-id="{!! $user->id !!}" data-no_wa="{!! $user->no_wa !!}" data-name="{!! $user->name !!}"><i class="fa fa-pencil"></i> {!! $user->no_wa !!}</a>
                                            @else
                                            <a href="#" class="btn-input-no-wa" data-id="{!! $user->id !!}" data-no_wa="{!! $user->no_wa !!}" data-name="{!! $user->name !!}"><i class="fa fa-pencil"></i> Input No WA</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == NULL)
                                                <a href="#" class="btn btn-sm btn-success btn-validasi" data-id="{{ $user->id }}">Validasi</a>
                                            @else
                                                {{ $user->status }}
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($user->bidang == NULL && $user->level == NULL)
                                                <a href="#" class="btn btn-sm btn-warning btn-edit-bidang" data-id="{{ $user->id }}">Input Bidang & Level</a>
                                            @else
                                            <a href="#" class="btn-edit-bidang" data-id="{{ $user->id }}" data-level="{{ $user->level }}" 
                                                data-bidang="{{ $user->bidang }}"><span class="badge bg-yellow">{{ $user->bidang.' / '.$user->level }}</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->usersUnit != null)
                                            <a href="#" class="btn btn-success btn-sm btn-user-unit-edit" data-id="{{ $user->usersUnit->id }}" data-u_id="{{ $user->usersUnit->unit_id }}">{!! $user->usersUnit->unit->nama !!}</a>
                                            @else
                                            <a href="#" class="btn btn-info btn-sm btn-user-unit-add" data-id="{{ $user->id }}">
                                                Pointing Unit
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status == 'Vendor')
                                            <a href="{!! url('pegawai-vendor?id='.$user->id) !!}" class="btn btn-info btn-sm"><i class="fa fa-users"></i> Pegawai</a>
                                            @endif

                                            <a href="#" data-id="{!! $user->id !!}" data-name="{!! $user->name !!}"
                                                data-email="{!! $user->email !!}" data-status="{!! $user->status !!}"
                                                class="btn btn-primary btn-sm btn-edit"><i class="fa fa-pencil"></i> Edit
                                            </a>
                                            
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $user->id !!}"><i
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
            </div>
        </div>
        
        @endsection
        @section('js')
        
        <script src="{!! asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
        <script src="{!! asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
        <script type="text/javascript">
            var mytable = $('#dataTable').DataTable({
                sDom : 'lrtip',
                "info" : false,
                "lengthChange" : false,
                "scrollX" : true,
                stateSave: true,
            })
            
            $('#key_search').on( 'keyup', function () {
                mytable.search( this.value ).draw();
            });

            $(document).on('click', '.btn-user-unit-edit', function () {
        
        $('#e_user_unit_id').val($(this).data('id'))
        $('#e_unit_pelaksana_id').val($(this).data('up_id'))
        
        
        $('#edit-user-unit-modal').modal('show')
    })
    
    $('#form_user_unit_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('users/unit/update') !!}",
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
                    location.reload()
                }
            }
        })
    })
    
    $(document).on('click', '.btn-edit-bidang', function () {
        
        $('#ub_id').val($(this).data('id'))
        $('#ub_bidang').val($(this).data('bidang'))
        $('#ub_level').val($(this).data('level'))
        
        $('#edit-bidang-modal').modal('show')
    })

    $('#form_bidang').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('users/update-level-bidang') !!}",
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

    $(document).on('click', '.btn-validasi', function () {
        
        $('#v_user_id').val($(this).data('id'))
        
        
        $('#validasi-modal').modal('show')
    })
    
    $('#form_validasi').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('users/validasi') !!}",
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

    $(document).on('click', '.btn-user-unit-add', function () {
        
        $('#user_unit_id').val($(this).data('id'))
        
        
        $('#add-user-unit-modal').modal('show')
    })
    
    $('#form_user_unit_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('users/unit/create') !!}",
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
                    location.reload()
                }
            }
        })
    })
    
            
            $(document).on('click', '.btn-edit', function () {
                
                $('#e_id').val($(this).data('id'))
                $('#e_name').val($(this).data('name'))
                $('#e_email').val($(this).data('email'))
                $('#e_status').val($(this).data('status'))
                
                $('#edit-user-modal').modal('show')
            })
            
            $(document).on('click','.btn-input-no-wa', function(e){
                e.preventDefault()
                $('#wa_id').val($(this).data('id'))
                $('#wa_name').val($(this).data('name'))
                $('#wa_no_wa').val($(this).data('no_wa'))
                
                $('#input-no-wa-modal').modal('show')
            })
            
            
            
            $('#form_input_no_wa').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    type: 'post',
                    url: "{!! url('users/input-no-wa') !!}",
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
                            location.reload()
                        }
                    }
                })
            })
            
            $('#form_user_add').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    type: 'post',
                    url: "{!! url('users/create') !!}",
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
                            location.reload()
                        }
                    }
                })
            })
            
            $('#form_user_edit').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    type: 'post',
                    url: "{!! url('users/update') !!}",
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
                            )
                            location.reload()
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
                    url: "{!! url('users/delete?id=') !!}" + id,
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
        