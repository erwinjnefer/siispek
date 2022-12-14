@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Sertifikat
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sertifikat</li>
    </ol>
</section>
@endsection
@section('content')

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
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <select class="form-control" name="jenis_pekerjaan">
                            <option>Pendirian Tiang</option>
                            <option>Penarikan Kabel</option>
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

<div class="modal fade" id="edit-sertifikat-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_sertifikat_edit" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload Sertifikat</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id">
                    <div class="form-group">
                        <label for="">Jenis Pekerjaan</label>
                        <select class="form-control" id="e_jenis_pekerjaan" name="jenis_pekerjaan">
                            <option>Pendirian Tiang</option>
                            <option>Penarikan Kabel</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" id="e_ket" class="form-control" name="ket">
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
    <div class="col-md-12   ">
        
        <div class="box box-default">
            <div class="box-header with-border">
                <i class="fa fa-book"></i> <b>DATA SERTIFIKAT</b>
                <div class="box-tools">
                    <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                    data-target="#add-sertifikat-modal">
                    <i class="fa fa-plus-circle"></i> Upload Sertifikat
                </button>
            </div>
        </div>
        <div class="box-body">
            <table width="100%" id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th width="7%">Jenis Pekerjaan</th>
                        <th width="10%">Keterangan</th>
                        <th width="10%">File</th>
                        <th width="3%" style="text-align: center;">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($sertifikat as $j)
                    <tr role="row" class="odd">
                        <td>{{ $no++ }}</td>
                        <td>{{ $j->jenis_pekerjaan }}</td>
                        <td>{{ $j->ket }}</td>
                        <td>
                            <a href="{{ url($j->file) }}"><i class="fa fa-file-o"></i> {{ $j->file }}</a>
                        </td>
                        <td align="center">
                            <a href="#" data-id="{!! $j->id !!}" data-jenis_pekerjaan="{!! $j->jenis_pekerjaan !!}" data-ket="{!! $j->ket !!}" class="btn btn-primary btn-sm btn-edit"><i
                                class="fa fa-pencil"></i>Edit
                            </a>
                            
                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $j->id !!}"><i
                                class="fa fa-trash-o"></i>Delete
                            </a>
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
        "scrollX" : true,
    })

    
    
    $(document).on('click', '.btn-edit', function () {
        
        $('#e_id').val($(this).data('id'))
        $('#e_jenis_pekerjaan').val($(this).data('jenis_pekerjaan'))
        $('#e_ket').val($(this).data('ket'))
        
        $('#edit-jsa-modal').modal('show')
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
                    )
                    location.reload()
                }
            }
        })
    })
    
    $('#form_sertifikat_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('sertifikat/update') !!}",
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
            url: "{!! url('sertifikat/delete?id=') !!}"+id,
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
