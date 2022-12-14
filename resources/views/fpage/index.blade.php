@extends('layouts.findex')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Inspeksi
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Inspeksi</li>
    </ol>
</section>
@endsection
@section('content')
<div class="row">
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

    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    {{-- <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary form-control btn-create">Create Work Permit</button>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" id="key_search" autocomplete="off" class="form-control" placeholder="Key Search">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="dataTable" width="100%" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl. Pengajuan</th>
                                    <th>Jenis Pekrjaan</th>
                                    <th>Unit</th>
                                    <th>Detail Pekrjaan</th>
                                    <th>Vendor</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($wp as $wp)
                                <tr>
                                    <td width="1%">{!! $no ++ !!}</td>
                                    <td width="5%">{!! date('d-m-Y', strtotime($wp->tgl_pengajuan)) !!}</td>
                                    <td width="5%">{!! $wp->jenis_pekerjaan !!}</td>
                                    <td width="15%">
                                        @if ($wp->jsa != null && $wp->workPermitProsedurKerja != null && $wp->workPermitHirarc != null)
                                        <a href="{{ url('finspeksi/detail?id='.$wp->id) }}">{!! $wp->detail_pekerjaan !!}</a>
                                        @else
                                        {!! $wp->detail_pekerjaan !!}
                                        @endif

                                        <a href="#" class="btn-logs" data-id="{{ $wp->woWp->work_order_id }}"><span class="badge bg-aqua"><i class="fa fa-history"></i></span></a>

                                    </td>
                                    <td width="5%">{{ $wp->unit->nama }}</td>
                                    <td width="5%">{{ $wp->users->name }}</td>
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
<script type="text/javascript">
    var mytable = $('#dataTable').DataTable({
        sDom : 'lrtip',
        "info" : false,
        "lengthChange" : false,
        "scrollX" : true,
        "pageLength":100,
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
</script>
@endsection