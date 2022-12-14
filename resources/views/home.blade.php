@extends('layouts.master')
@section('css')
<style>
    #chartdiv {
      width: 100%;
      height: 500px;
    }
    </style>
@endsection
@section('content-header')
<section class="content-header">
    <h1>
        Dashboard
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-dashboard"></i> Home</li>
    </ol>
</section>
@endsection
@section('content')

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

<div class="modal fade" id="cari-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="get" action="{{ url('home') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">PENCARIAN</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" required name="month">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="row">
    {{-- {{ Auth::user() }} --}}
    @if(Auth::user()->status != NULL)
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{!! count($wp) !!}</h3>

                <p>Work Permit</p>
            </div>
            <div class="icon">
                <i class="fa fa-check"></i>
            </div>
            <a href="{!! url('work-permit') !!}" class="small-box-footer">More info <i
                    class="fa fa-arrow-circle"></i></a>
        </div>
    </div>



    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{!! count($unit) !!}</h3>

                <p>Unit</p>
            </div>
            <div class="icon">
                <i class="fa fa-home"></i>
            </div>
            <a href="{!! url('vendors') !!}" class="small-box-footer">More info <i class="fa fa-arrow-circle"></i></a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Grafik Pekerjaan</h4>
                <div class="box-tools">
                    <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                        data-target="#cari-modal">
                        <i class="fa fa-calendar"></i> Cari Tanggal
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div id="chartdiv"></div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h4>Resume Status Pekerjaan</h4>
                <div class="box-tools">
                    {{-- <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal"
                        data-target="#cari-modal">
                        <i class="fa fa-calendar"></i> Cari Tanggal
                    </button> --}}
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" id="key_search" placeholder="Search ...">
                        </div>
                    </div>

                    <div class="col-md-12" style="margin-top: 10px;">
                        <table id="dataTable" width="100%" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Detail Pekrjaan</th>
                                    <th>No.SPK</th>
                                    <th>Vendor</th>
                                    <th>Tgl. Awal</th>
                                    <th>Tgl. Selesai</th>
                                    <th>Unit</th>
                                    <th>Tanggal WO</th>
                                    <th>Work Permit</th>
                                    <th>Inspeksi Pekerjaan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($resume as $wo)
                                    <tr>
                                        <td width="1%">{!! $no ++ !!}</td>
                                        <td width="5%">{!! $wo->nama !!} <a href="#" class="btn-logs"
                                                data-id="{{ $wo->id }}"><span class="badge bg-aqua"><i
                                                        class="fa fa-history"></i></span></a></td>
                                        <td width="5%">{!! $wo->spk_no !!}</td>
                                        <td width="5%">{{ $wo->users_name }}</td>
                                        <td width="5%">{!! $wo->tgl_mulai != null ? date('d-m-Y',
                                            strtotime($wo->tgl_mulai)) : '' !!}</td>
                                        <td width="5%">{!! $wo->tgl_selesai != null ? date('d-m-Y',
                                            strtotime($wo->tgl_selesai)) : '' !!}</td>
                                        <td width="5%">{{ $wo->u_nama }}</td>
                                        <td width="5%">{!! date('d-m-Y', strtotime($wo->date)) !!}</td>
                                        <td width="5%" align="center">
                                            @if($wo->man_app_date != null)
                                                <a class="btn btn-success"><i class="fa fa-check"></i></a>
                                            @endif
                                        </td>
                                        <td align="center" width="3%">
                                            @if($wo->inspeksi_id != null)
                                                <a
                                                    class="btn {!! $wo->inspeksi_status == 'SWA' ? 'btn-danger' : 'btn-success' !!}">{!!
                                                    $wo->inspeksi_status == 'SWA' ? '<i class="fa fa-close"></i> SWA' :
                                                    '<i class="fa fa-check"></i>' !!}</a>
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
        
        @else
        <div class="col-md-12">
            
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                Akun anda dalam proses validasi oleh ADMIN, terimakasih !
            </div>
        </div>
        @endif
    </div>
    
    @endsection
    @section('js')
    <script src="{!! asset('/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}"></script>
    <script src="{{ asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script>
        var mytable = $('#dataTable').DataTable({
            sDom: 'lrtip',
            "info": false,
            "lengthChange": false,
            "scrollX": true,
            "pageLength": 100
        })
        
        $('.date').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        })
        
        $('#key_search').on('keyup', function () {
            mytable.search(this.value).draw();
        });
        
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

        loadChart()

        function loadChart() {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.legend = new am4charts.Legend();

                chart.data = @json($data_chart, JSON_PRETTY_PRINT);

                chart.innerRadius = 100;

                var series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "value";
                series.dataFields.category = "cat";
                


            });
        }
        
        
    </script>
    @endsection
    