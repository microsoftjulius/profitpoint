<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Profit point</title>

    <link href="{{ asset('design/css/style.default.css')}}" rel="stylesheet">
    <style type="text/javascript">
        #show_bg_2 {
        background-image:
        linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73)),
        url();
        width: 80%;
        height: 400px;
        background-size: cover;
        color: white;
        padding: 20px;
    }
    </style>
</head>

    <body class="signin" style="background-image: url('{{ asset("design/images/background.jpg")}}'); background-repeat: no-repeat;
        background-attachment: fixed;  background-size: cover; linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73)),">
        
        
        <section>
            
            <div class="panel panel-signin">
                <div class="panel-body">
                    <div class="logo text-center">
                        <img src="{{ asset('design/images/logo-primary.png')}}" alt="Chain Logo" >
                    </div>
                    <br />
                    <h4 class="text-center mb5">Already a Member?</h4>
                    <p class="text-center">Sign in to your account</p>
                    
                    <div class="mb30"></div>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div><!-- input-group -->
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div><!-- input-group -->
                        
                        <div class="clearfix">
                            <div class="pull-left">
                                <div class="ckbox ckbox-primary mt10">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="pull-left pt-1">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            
                        </div>    
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-lg-4">
        
                                    <button type="submit" class="btn btn-success">Sign In <i class="fa fa-angle-right ml5"></i></button>
                                </div>
                                <div class="col-lg-1"></div>
                                <div class="col-lg-7">
                                    <a href="/register" class="btn btn-primary btn-block">Sign up</a></div>
                            </div>
                        </div><!-- panel-footer -->                  
                    </form>
                    
                </div><!-- panel-body -->
                
            </div><!-- panel -->
            
        </section>


        <script src="{{ asset('design/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery-migrate-1.2.1.min.js')}}"></script>
        <script src="{{ asset('design/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('design/js/modernizr.min.js')}}"></script>
        <script src="{{ asset('design/js/pace.min.js')}}"></script>
        <script src="{{ asset('design/js/retina.min.js')}}"></script>
        <script src="{{ asset('design/js/jquery.cookies.js')}}"></script>

        <script src="{{ asset('design/js/custom.js')}}"></script>

    </body>

<!-- Mirrored from themetrace.com/demo/chain/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 28 Mar 2020 04:33:15 GMT -->
</html>
