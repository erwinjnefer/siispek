<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Work Permit</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{!! asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('admin/bower_components/font-awesome/css/font-awesome.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('admin/bower_components/Ionicons/css/ionicons.min.css') !!}">
    <!-- Theme style -->
    @yield('css')
    <link rel="stylesheet" href="{!! asset('admin/css/AdminLTE.min.css') !!}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{!! asset('admin/css/skins/_all-skins.min.css') !!}">
        <link rel="stylesheet" href="{!! asset('/sweetalert2/sweetalert2.min.css') !!}">
        
        
        
        
        <meta name="csrf-token" content="{!! csrf_token() !!}">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
            
            <!-- Google Font -->
            <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
            
            <style>
                
                
                @media (min-width: 768px) {
                    .modal-xl {
                        width: 90%;
                        max-width:1200px;
                    }
                }
                
                .modal {
                    overflow-y: scroll;
                }
            </style>
        </head>
        
        <body class="hold-transition skin-red sidebar-mini">
            <!-- Site wrapper -->
            <div class="wrapper">
                
                <header class="main-header">
                    <!-- Logo -->
                    <a href="{!! url('/finspeksi') !!}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini">
                            <img src="{!! asset('inspeksi.png') !!}" width="70%" alt="">
                        </span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">
                            <b>INSPEKSI ONLINE</b>
                            {{-- <img src="{!! asset('workpermit.png') !!}" class="brandlogo-image" width="70%" alt=""> --}}
                        </span>
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="{!! asset('admin/img/user2-160x160.jpg') !!}" class="user-image" alt="User Image">
                                        <span class="hidden-xs">{!! Session::get('auth')->nama !!}</span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li class="user-header">
                                            <img src="{!! asset('admin/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image">
                                            
                                            <p>
                                                {!! Session::get('auth')->nama !!}
                                                <small>Member since Nov. 2012</small>
                                            </p>
                                        </li>
                                        <!-- Menu Body -->
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('logout-pegawai') }}"  class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Control Sidebar Toggle Button -->
                                <li>
                                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                
                <!-- =============================================== -->
                
                <!-- Left side column. contains the sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="{!! asset('admin/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p>{!! Session::get('auth')->nama !!}</p>
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        
                        <ul class="sidebar-menu" data-widget="tree">
                            <li class="header">MAIN NAVIGATION</li>
                            <li>
                                <a href="{!! url('finspeksi') !!}">
                                    <i class="fa fa-book"></i> <span>Inspeksi</span>
                                </a>
                            </li>
                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>
                
                <!-- =============================================== -->
                
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    @yield('content-header')
                    <section class="content">
                        @yield('content')
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 2.4.0
                    </div>
                    <strong>Copyright &copy; 2021 <a href="http://sscpln.com">SSCPLN.COM</a>.</strong> All rights
                    reserved.
                </footer>
                
                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Create the tabs -->
                    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                        
                        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Home tab content -->
                        <div class="tab-pane" id="control-sidebar-home-tab">
                            <h3 class="control-sidebar-heading">Recent Activity</h3>
                            <ul class="control-sidebar-menu">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                        
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                            
                                            <p>Will be 23 on April 24th</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-user bg-yellow"></i>
                                        
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                            
                                            <p>New phone +1(800)555-1234</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                                        
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                            
                                            <p>nora@example.com</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-file-code-o bg-green"></i>
                                        
                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                            
                                            <p>Execution time 5 seconds</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.control-sidebar-menu -->
                            
                            <h3 class="control-sidebar-heading">Tasks Progress</h3>
                            <ul class="control-sidebar-menu">
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Custom Template Design
                                            <span class="label label-danger pull-right">70%</span>
                                        </h4>
                                        
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Update Resume
                                            <span class="label label-success pull-right">95%</span>
                                        </h4>
                                        
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Laravel Integration
                                            <span class="label label-warning pull-right">50%</span>
                                        </h4>
                                        
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Back End Framework
                                            <span class="label label-primary pull-right">68%</span>
                                        </h4>
                                        
                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.control-sidebar-menu -->
                            
                        </div>
                        <!-- /.tab-pane -->
                        <!-- Stats tab content -->
                        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                        <!-- /.tab-pane -->
                        <!-- Settings tab content -->
                        <div class="tab-pane" id="control-sidebar-settings-tab">
                            <form method="post">
                                <h3 class="control-sidebar-heading">General Settings</h3>
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Report panel usage
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                    
                                    <p>
                                        Some information about this general settings option
                                    </p>
                                </div>
                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Allow mail redirect
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                    
                                    <p>
                                        Other sets of options are available
                                    </p>
                                </div>
                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Expose author name in posts
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                    
                                    <p>
                                        Allow the user to show his name in blog posts
                                    </p>
                                </div>
                                <!-- /.form-group -->
                                
                                <h3 class="control-sidebar-heading">Chat Settings</h3>
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Show me as online
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                </div>
                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Turn off notifications
                                        <input type="checkbox" class="pull-right">
                                    </label>
                                </div>
                                <!-- /.form-group -->
                                
                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Delete chat history
                                        <a href="javascript:void(0)" class="text-red pull-right"><i
                                            class="fa fa-trash-o"></i></a>
                                        </label>
                                    </div>
                                    <!-- /.form-group -->
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                    </aside>
                    <!-- /.control-sidebar -->
                    <!-- Add the sidebar's background. This div must be placed
                        immediately after the control sidebar -->
                        <div class="control-sidebar-bg"></div>
                    </div>
                    <!-- ./wrapper -->
                    
                    <!-- jQuery 3 -->
                    <script src="{!! asset('admin/bower_components/jquery/dist/jquery.min.js') !!}"></script>
                    <!-- Bootstrap 3.3.7 -->
                    <script src="{!! asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
                    <!-- SlimScroll -->
                    <script src="{!! asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}"></script>
                    <!-- FastClick -->
                    <script src="{!! asset('admin/bower_components/fastclick/lib/fastclick.js') !!}"></script>
                    <!-- AdminLTE App -->
                    <script src="{!! asset('admin/js/adminlte.min.js') !!}"></script>
                    <!-- AdminLTE for demo purposes -->
                    <script src="{!! asset('admin/js/demo.js') !!}"></script>
                    <script src="{!! asset('sweetalert2/sweetalert2.min.js') !!}"></script>
                    <script>
                        $(document).ready(function () {
                            $('.sidebar-menu').tree()
                        })
                        
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        
                        var nf = Intl.NumberFormat()
                        
                        function showPleaseWait() {
                            var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
                                <div class="modal-dialog">\
                                    <div class="modal-content">\
                                        <div class="modal-header">\
                                            <h4 class="modal-title">Please wait...</h4>\
                                        </div>\
                                        <div class="modal-body">\
                                            <div class="progress">\
                                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';
                        $(document.body).append(modalLoading);
                        $("#pleaseWaitDialog").modal("show");
                    }
                    
                    
                    function hidePleaseWait() {
                        $("#pleaseWaitDialog").modal("hide");
                    }
                    
                </script>
                
                
                @yield('js')
                
            </body>
            
            </html>
            