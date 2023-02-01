@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Apk
        <small>File</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Apk Update</li>
    </ol>
</section>
@endsection
@section('content')

<div class="modal fade" id="add-video-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_video_add" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload File Apk</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    
                    <div class="form-group">
                        <label for="">Version</label>
                        <input type="text" class="form-control" name="version">
                    </div>
                    
                    <div class="form-group">
                        <label for="">File Apk</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>

                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi" rows="3"></textarea>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary pull-left">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-video-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_video_edit" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Upload File Apk</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id">
                    
                    
                    <div class="form-group">
                        <label for="">Version</label>
                        <input type="text" id="e_version" class="form-control" name="version">
                    </div>
                    
                    <div class="form-group">
                        <label for="">File Apk</label>
                        <input type="file" class="form-control" accept=".apk" name="file">
                    </div>

                    <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea type="text" class="form-control" id="e_deskripsi" name="deskripsi" rows="3"></textarea>
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
                <i class="fa fa-book"></i> <b>DATA APK</b>
                <div class="box-tools">
                    @if ($apk->count() == 0)
                        <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                            data-target="#add-video-modal">
                            <i class="fa fa-plus-circle"></i> Upload Video
                        </button>
                    @endif
            </div>
        </div>
        <div class="box-body">
            <table width="100%" id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th width="10%">Version</th>
                        <th width="10%">Deskripsi</th>
                        <th width="5%">File</th>
                        <th width="3%" style="text-align: center;">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($apk as $v)
                    <tr role="row" class="odd">
                        <td>{{ $no++ }}</td>
                        <td>{{ $v->version }}</td>
                        <td>{{ $v->deskripsi }}</td>
                        <td>
                            <a href="{{ url('file/'.$v->file) }}"><i class="fa fa-file-o"></i> {{ $v->file }}</a>
                        </td>
                        <td align="center">
                            <a href="#" data-id="{!! $v->id !!}" data-version="{!! $v->version !!}" data-deskripsi="{{ $v->deskripsi }}" class="btn btn-primary btn-sm btn-edit"><i
                                class="fa fa-pencil"></i>Edit
                            </a>
                            
                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $v->id !!}"><i
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
        $('#e_version').val($(this).data('version'))
        $('#e_deskripsi').val($(this).data('deskripsi'))
        
        
        $('#edit-video-modal').modal('show')
    })
    
    
    
    $('#form_video_add').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('apk-update/create') !!}",
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
    
    $('#form_video_edit').on('submit', function (e) {
        e.preventDefault()
        showPleaseWait()
        $.ajax({
            type: 'post',
            url: "{!! url('apk-update/update') !!}",
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
            url: "{!! url('apk-update/delete?id=') !!}"+id,
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
