@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Work Order
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Work Order</li>
    </ol>
</section>
@endsection
@section('content')
<div class="modal fade" id="create-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_create">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Create Work Order</h4>
                </div>
                <div class="modal-body">
                    @csrf

                    <div class="form-group">
                        <label for="">Nama Pekerjaan</label>
                        <textarea name="nama" rows="3" required class="form-control"></textarea>
                    </div>
                
                    <div class="form-group">
                        <label for="">Nomor SPK</label>
                        <input type="text" name="spk_no" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Unit</label>
                        <select required name="unit_id" class="form-control">
                            @foreach ($unit as $un)
                                <option value="{{ $un->id }}">{{ $un->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- @if(Auth::user()->status == 'Admin' || (Auth::user()->status == 'Manajer' && Auth::user()->usersUnit->unit->nama == 'UP2K'))
                    @else
                    <div class="form-group">
                        <label for="">Unit</label>
                        <input type="text" readonly value="{{ (Auth::user()->usersUnit != null) ? Auth::user()->usersUnit->unit->nama : '' }}" class="form-control">
                    </div>
                    @endif --}}
                
                    
                    <div class="form-group">
                        <label for="">Vendor</label>
                        <select name="vendor_id" class="form-control" required>
                            <option value=""></option>
                            @foreach ($user as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Mulai</label>
                                <input type="text" name="tgl_mulai" autocomplete="off" class="form-control date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Tgl. Selesai</label>
                                <input type="text" name="tgl_selesai" autocomplete="off" class="form-control date" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">File</label>
                        <input type="file" name="file" class="form-control">
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
                    <h4 class="modal-title">Edit Level Bagian</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="wp_id" name="id">
                    
                    <div class="form-group">
                        <label for="">Bagian</label>
                        <select name="bidang" id="wp_bidang" class="form-control">
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

                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="logs-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Logs History</h4>
                </div>
                <div class="modal-body">
                    <div class="timeline" id="timeline_item">

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
           
        </div>
    </div>
</div>

<div class="modal fade" id="edit-unit-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_unit_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Unit</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_uid" name="id">
                    
                    <div class="form-group">
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

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    @if(Auth::user()->status != 'Vendor')
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary form-control" data-toggle="modal" data-target="#create-modal" title="Create Work Order"><i class="fa fa-pencil"></i> CREATE WORK ORDER</button>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-10">
                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="dataTable" width="100%" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Detail Pekrjaan</th>
                                    <th>No.SPK</th>
                                    <th>Vendor</th>
                                    <th>Tgl. Awal</th>
                                    <th>Tgl. Selesai</th>
                                    <th>File</th>
                                    <th>Unit</th>
                                    <th>Work Permit</th>
                                    <th style="text-align: center">Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($wo as $wo)
                                <tr>
                                    <td width="1%">{!! $no ++ !!}</td>
                                    <td width="5%">{!! date('d-m-Y', strtotime($wo->date)) !!}</td>
                                    <td width="5%">{!! $wo->nama !!} <a href="#" class="btn-logs" data-id="{{ $wo->id }}"><span class="badge bg-aqua"><i class="fa fa-history"></i></span></a></td>
                                    <td width="5%">{!! $wo->spk_no !!}</td>
                                    <td width="5%">{{ $wo->users->name }}</td>
                                    <td width="5%">{!! $wo->tgl_mulai != null ? date('d-m-Y', strtotime($wo->tgl_mulai)) : '' !!}</td>
                                    <td width="5%">{!! $wo->tgl_selesai != null ? date('d-m-Y', strtotime($wo->tgl_selesai)) : '' !!}</td>
                                    <td width="5%" align="center">
                                        @if ($wo->file != null)
                                            <a href="{{ url($wo->file) }}"><span class="badge bg-aqua"><i class="fa fa-cloud-download"></i> Download</span></a>
                                        @endif
                                    </td>
                                    <td width="5%">
                                        @if(Auth::user()->status == 'Admin')
                                        <a href="#" class="btn-unit-edit" data-id="{{ $wo->id }}" data-u_id="{{ $wo->unit_id }}">{!! $wo->unit->nama !!}</a>
                                        @else
                                        {{ $wo->unit->nama }}
                                        @endif
                                    </td>
                                    <td width="5%">
                                        @if($wo->woWp != null)
                                        <a class="btn btn-success" href="{{ url('work-permit/detail?id='.$wo->woWp->work_permit_id) }}">BUKA WORK PERMIT</a>
                                        @else

                                        @if($create_wp == 'YES')
                                        <a class="btn btn-warning" href="{{ url('work-permit/form?id='.$wo->id) }}">CREATE WORK PERMIT</a>
                                        @else
                                        <span class="badge bg-yellow">Masih ada SWA yang belum terselesaikan</span>
                                        @endif
                                        
                                        @endif
                                    </td>
                                    <td align="center" width="3%">
                                        @if(Auth::user()->status != 'Vendor')
                                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $wo->id }}">Delete</a>
                                        @endif
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

<script src="{!! asset('/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
<script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    var mytable = $('#dataTable').DataTable({
        sDom : 'lrtip',
        "info" : false,
        "lengthChange" : false,
        "scrollX" : true,
        "pageLength" : 100
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    })
    
    $('#key_search').on( 'keyup', function () {
        mytable.search( this.value ).draw();
    });

    $(document).on('click', '.btn-logs', function () {
        var id = $(this).data('id')
        showPleaseWait()

        $.ajax({
            type : 'GET',
            url : "{{ url('logs-history?id=') }}"+id,
            success : function(r){
                console.log(r)
                hidePleaseWait()
                $('#logs-modal').modal('show')
                $("#timeline_item").empty()

                $.each(r.logs, function(i, d){
                    $("#timeline_item").append(
                        '<li class="time-label"><span class="bg-red">'+d.date+'</span></li>\
                        <li>\
                        <i class="fa fa-user bg-aqua"></i>\
                        <div class="timeline-item">\
                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>\
                        <h3 class="timeline-header no-border"><a href="#">'+d.users+'</a> '+d.nama+'</h3>\
                        </div>\
                        </li>'
                    )
                })

            }
        })
    })

    $(document).on('click', '.btn-unit-edit', function () {
        
        $('#e_uid').val($(this).data('id'))
        $('#e_unit_id').val($(this).data('u_id'))
      
        
        $('#edit-unit-modal').modal('show')
    })

    $('#form_unit_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('work-order/edit-unit') !!}",
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

    $(document).on('click', '.edit-bidang', function () {
        
        $('#wp_id').val($(this).data('id'))
        $('#wp_bidang').val($(this).data('bidang'))
      
        
        $('#edit-bidang-modal').modal('show')
    })

    $('#form_create').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('work-order/create') !!}",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (r) {
                hidePleaseWait()
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

    $('#form_bidang').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('work-permit/update-bidang') !!}",
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
    
  

    $(document).on("click", ".btn-delete", function (e) {
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
                del(id)
            }
        })
    });


    function del(id) {
        $.ajax({
            type: 'get',
            url: "{!! url('work-order/delete?id=') !!}"+id,
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