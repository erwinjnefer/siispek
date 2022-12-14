<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WP | Register</title>
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

        <div class="login-box">
            <div class="login-logo">
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg"><img src="{!! asset('plnlogo.png') !!}" style="width: 30%" alt=""></p>
                <p class="login-box-msg"><b style="font-size: 16pt;color: rgb(235, 69, 18)">WORK PERMIT & INSPEKSI ONLINE</b></p>
                
                {{-- <p class="login-box-msg">Sign in to start your session</p> --}}
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group has-feedback">
                        <input type="text" name="name" required class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

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

                    <div class="form-group has-feedback">
                        <input type="text" name="no_wa" class="form-control @error('no_wa') is-invalid @enderror" placeholder="No Whatsapp" value="{{ old('no_wa') }}">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        @error('no_wa')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-5">
                            <button type="submit" class="btn btn-success btn-block btn-flat">Register</button>
                        </div>
                        {{-- <div class="col-xs-7">
                            <a href="#" data-toggle="modal" data-target="#login-pegawai-modal" class="btn btn-primary btn-block btn-flat btn-login-pegawai">Login Pegawai Vendor</a>
                        </div> --}}
                        <!-- /.col -->
                    </div>

                    {{-- <br> --}}
                    {{-- <a href="{!! url('login') !!}" class="text-center">Login</a> --}}
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
            
        </script>
    </body>
    
    </html>
    