<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Earn 2% daily with profit point forex trading investement. The world of financial freedom</title>

        <link href="{{ asset('design/css/style.default.css')}}" rel="stylesheet">
    </head>

    <body class="signin" style="background-image: url('{{ asset("design/images/profitpoint.jpg")}}'); background-repeat: no-repeat;
        background-attachment: fixed;  background-size: cover; linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(117, 19, 93, 0.73))">
        
        
        <section>
            
            <div class="panel panel-signin">
                <div class="panel-body">
                    <div class="logo text-center">
                        <img src="{{ asset('design/images/profit.png')}}" alt="Profit Point Logo" style="height:100px; width:200px">
                    </div>
                    <br />
                    <h4 class="text-center mb5">Earn 2% daily with profit point forex trading investement.</h4>
                    <p class="text-center">The world of financial freedom</p>
                    
                    <div class="mb30"></div>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm&nbsp;Password</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
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

