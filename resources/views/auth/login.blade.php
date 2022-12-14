<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIISPEK | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{!! asset('/sweetalert2/sweetalert2.min.css') !!}">
    <!-- iCheck -->
    
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <!-- Google Font -->
        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        
    </head>
    
    <body class="hold-transition login-page">

        <div class="modal fade" id="login-pegawai-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="form_login_pegawai" enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Login Pegawai</h4>
                        </div>
                        <div class="modal-body">
                            @csrf
                            
                            <div class="form-group">
                               <label for="">Username</label>
                               <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="form-group">
                               <label for="">Password</label>
                               <input type="password" name="password" class="form-control" required>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-left">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="login-box">
            <div class="login-logo">
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg"><img src="{!! asset('plnlogo.png') !!}" style="width: 30%" alt=""></p>
                <p class="login-box-msg"><b style="font-size: 16pt;color: rgb(235, 69, 18)">SIISPEK</b> <br><b style="color: #04ADF0">Sosialisasi, Ijin kerja dan InSPEKsi online</b></p>
                
                {{-- <p class="login-box-msg">Sign in to start your session</p> --}}
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-5">
                            <button type="submit" class="btn btn-success btn-block btn-flat">Login User</button>
                        </div>
                        <div class="col-xs-7">
                            <a href="#" data-toggle="modal" data-target="#login-pegawai-modal" class="btn btn-primary btn-block btn-flat btn-login-pegawai">Login Pegawai Vendor</a>
                        </div>
                        <!-- /.col -->
                    </div>

                    <br>
                    <a href="{!! url('register') !!}" class="text-center">Register a new user</a>
                </form>
                
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
        
        <!-- jQuery 3 -->
        <script src="admin/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        {{-- <script src="admin/plugins/iCheck/icheck.min.js"></script> --}}
        <script src="{!! asset('sweetalert2/sweetalert2.min.js') !!}"></script>
        <script>
            $('#form_login_pegawai').on('submit', function (e) {
                e.preventDefault()
                $.ajax({
                    type: 'post',
                    url: "{!! url('login-pegawai') !!}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r) {
                        console.log(r)
                        if (r.msg == 'success') {
                            Swal.fire(
                                'Login successfully !',
                                'Welcome, '+r.user.nama+' !',
                                'success'
                            ).then(function () {
                                window.location = "{!! url('finspeksi') !!}"
                            })
                        }else{
                            Swal.fire(
                                'Login failed !',
                                'Username or Password is wrong !',
                                'error'
                            )
                        }
                    }
                })
            })
        </script>
    </body>
    
    </html>
    