@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Unit
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Unit</li>
    </ol>
</section>
@endsection
@section('content')

<div class="modal fade" id="add-unit-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_unit_add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Tambah Unit</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama Unit</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary pull-left">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <div class="modal fade" id="edit-unit-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_unit_edit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Unit</h4>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" id="e_id" name="id">
                            <div class="form-group">
                                <label for="">Nama Unit</label>
                                <input type="text" class="form-control" id="e_nama" name="nama">
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
            <div class="col-md-6">
                
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i> <b>DATA UNIT</b>
                        <div class="box-tools">
                            <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                            data-target="#add-unit-modal">
                            <i class="fa fa-plus-circle"></i> Create Unit
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <table width="100%" id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="15%">Nama Vendor</th>
                                <th width="3%" style="text-align: center;">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($unit as $unit)
                            <tr role="row" class="odd">
                                <td>{{ $no++ }}</td>
                                <td>{{ $unit->nama }}</td>
                                <td align="center">
                                    <a href="#" data-id="{!! $unit->id !!}" data-nama="{!! $unit->nama !!}" class="btn btn-primary btn-sm btn-edit"><i
                                        class="fa fa-pencil"></i>Edit
                                    </a>
                                    
                                    <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $unit->id !!}"><i
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
            $('#e_nama').val($(this).data('nama'))
            
            $('#edit-unit-modal').modal('show')
        })
        
        
        
        $('#form_unit_add').on('submit', function (e) {
            e.preventDefault()
            $.ajax({
                type: 'post',
                url: "{!! url('unit/create') !!}",
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
        
        $('#form_unit_edit').on('submit', function (e) {
            e.preventDefault()
            $.ajax({
                type: 'post',
                url: "{!! url('unit/update') !!}",
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
                url: "{!! url('unit/delete?id=') !!}"+id,
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
    