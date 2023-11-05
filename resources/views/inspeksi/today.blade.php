@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! asset('/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}">
<link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Pekerjaan Berlangsung
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('home') !!}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Inspeksi Berlangsung</li>
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

    <div class="modal fade" id="filter-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_filter" method="get" action="{{ url('inspeksi/today') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Filter Tanggal</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        
                        
                        <div class="form-group">
                            <input type="text" required readonly name="date" class="form-control date">
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-warning form-control" data-toggle="modal" data-target="#filter-modal" title="Filter Tanggal"><i class="fa fa-calendar"></i> FILTER TANGGAL</button>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                        </div>

                        {{-- <div class="form-group">
                            <input type="text" id="key_search" class="form-control" placeholder="Key Search">
                        </div> --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="dataTable" width="100%" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl. Pelaksanaan</th>
                                    <th>Jenis Pekrjaan</th>
                                    <th>Detail Pekrjaan</th>
                                    <th>Unit</th>
                                    <th>Vendor</th>
                                    <th style="text-align: center">Approval</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $no = 1;
                                @endphp
                                @foreach ($wp as $wp)
                                <tr>
                                    <td width="1%">{!! $no ++ !!}</td>
                                    <td width="5%">{!! date('d-m-Y', strtotime($wp->tgl_rencana_pelaksanaan)) !!}</td>
                                    <td width="5%">{!! $wp->jenis_pekerjaan !!}</td>
                                    <td width="15%">
                                        @if ($wp->jsa != null && $wp->workPermitProsedurKerja != null && $wp->workPermitHirarc != null)
                                        <a href="{{ url('inspeksi/detail?id='.$wp->id) }}">{!! $wp->detail_pekerjaan !!}</a>
                                        @else
                                        {!! $wp->detail_pekerjaan !!}
                                        @endif

                                        <a href="#" class="btn-logs"
                                        data-id="{{ $wp->woWp->work_order_id }}"><span class="badge bg-aqua"><i
                                                class="fa fa-history"></i></span></a>
                                    </td>
                                    <td width="5%">{{ $wp->unit->nama }}</td>
                                    <td width="5%">{{ $wp->users->name }}</td>
                                    <td align="center" width="3%">
                                        @if($wp->wpApproval->man_app != null)
                                        <span class="badge bg-green">Complete</span>
                                        @else
                                        <span class="badge bg-yellow">Waiting</span>
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
    })
    
    $('#key_search').on( 'keyup', function () {
        mytable.search( this.value ).draw();
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
    })
    

    $(document).on('click', '.btn-logs', function (e) {
        e.preventDefault()
        var id = $(this).data('id')
        showPleaseWait()

        $.ajax({
            type: 'GET',
            url: "{{ url('logs-history?id=') }}" + id,
            success: function (r) {
                console.log(r)
                hidePleaseWait()
                $('#logs-modal').modal('show')
                $("#timeline_item").empty()

                $.each(r.logs, function (i, d) {
                    $("#timeline_item").append(
                        '<li class="time-label"><span class="bg-red">' + d.date + '</span></li>\
                        <li>\
                            <i class="fa fa-user bg-aqua"></i>\
                            <div class="timeline-item">\
                                <span class="time"><i class="fa fa-clock-o"></i>    </span>\
                                <h3 class="timeline-header no-border"><a href="#">' + d.users + '</a> ' + d.nama + '</h3>\
                            </div>\
                        </li>'
                    )
                })

            }
        })
    })
    
    
</script>
@endsection