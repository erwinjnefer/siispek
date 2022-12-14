@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endsection
@section('content')




<div class="modal fade" id="add-bk-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_bk_add">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah BK</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" name="nama">
                    </div>


                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" class="form-control">
                            <option>BA</option>
                            <option>Non BA</option>
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


<div class="modal fade" id="edit-bk-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_bk_edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Vendor</h4>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="e_id" name="id">
                    <div class="form-group">
                        <label for="">Nama BK</label>
                        <input type="text" class="form-control" id="e_nama" name="nama">
                    </div>


                    <div class="form-group">
                        <label for="">Kategori</label>
                        <select name="kategori" class="form-control" id="e_kategori">
                            <option>BA</option>
                            <option>Non BA</option>
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


<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-book"></i> <b>DATA BK</b>
        <div class="box-tools">
            <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                data-target="#add-bk-modal">
                <i class="fa fa-plus-circle"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($bk as $bk)
                <tr role="row" class="odd">
                    <td>{{ $no++ }}</td>
                    <td>{{ $bk->nama }}</td>
                    <td>{{ $bk->kategori }}</td>
                    <td>
                        <a href="#" data-id="{!! $bk->id !!}" data-nama="{!! $bk->nama !!}"
                            data-kategori="{!! $bk->kategori !!}" class="btn btn-primary btn-sm btn-edit"><i
                                class="fa fa-pencil"></i>Edit</a>

                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{!! $bk->id !!}"><i
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

<script src="/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $('#dataTable').DataTable()

    $(document).on('click', '.btn-edit', function () {

        $('#e_id').val($(this).data('id'))
        $('#e_nama').val($(this).data('nama'))
        $('#e_kategori').val($(this).data('kategori'))

        $('#edit-bk-modal').modal('show')
    })



    $('#form_bk_add').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('bk/create') !!}",
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

    $('#form_bk_edit').on('submit', function (e) {
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: "{!! url('bk/update') !!}",
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
            url: "{!! url('bk/delete?id=') !!}"+id,
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
