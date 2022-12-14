@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content')




<div class="modal fade" id="add-vendor-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_vendor_add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Vendor</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama Vendor</label>
                        <input type="text" class="form-control" name="nama">
                    </div>


                    <div class="form-group">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" class="form-control" name="no_wa">
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


<div class="modal fade" id="edit-vendor-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_vendor_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Vendor</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id">
                    <div class="form-group">
                        <label for="">Nama Vendor</label>
                        <input type="text" class="form-control" id="e_nama" name="nama">
                    </div>


                    <div class="form-group">
                        <label for="">Nomor Whatsapp</label>
                        <input type="text" class="form-control" id="e_no_wa" name="no_wa">
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


<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-book"></i> <b>DATA VENDOR</b>
        <div class="box-tools">
            <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                data-target="#add-vendor-modal">
                <i class="fa fa-plus-circle"></i> Create Vendor
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Nomor Whatsapp</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($vendor as $vendor)
                <tr role="row" class="odd">
                    <td>{{ $no++ }}</td>
                    <td>{{ $vendor->nama }}</td>
                    <td>{{ $vendor->no_wa }}</td>
                    <td align="center">
                        <a href="#" data-id="{!! $vendor->id !!}" data-nama="{!! $vendor->nama !!}"
                            data-no_wa="{!! $vendor->no_wa !!}" class="btn btn-primary btn-sm btn-edit"><i
                                class="fa fa-pencil"></i>Edit</a>

                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $vendor->id !!}"><i
                                class="fa fa-trash-o"></i>Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
@endsection
@section('js')

<script src="{!! asset('/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
<script type="text/javascript">
    $('#dataTable').DataTable()

    $(document).on('click', '.btn-edit', function () {

        $('#e_id').val($(this).data('id'))
        $('#e_nama').val($(this).data('nama'))
        $('#e_no_wa').val($(this).data('no_wa'))

        $('#edit-vendor-modal').modal('show')
    })



    $('#form_vendor_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('vendors/create') !!}",
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

    $('#form_vendor_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('vendors/update') !!}",
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
            url: "{!! url('vendors/delete?id=') !!}"+id,
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
