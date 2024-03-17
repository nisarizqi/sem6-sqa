@extends('layouts.app')

@section('content')

    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LdgLpspAAAAACFp5_RXeNT1CbiYwvEQx4UD_4PF'
        });
      };
    </script>

    <section class="contact spad">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__map set-bg" data-setbg="/assets/img/hero/hero-1.jpg">
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <h3>Log in to your account</h3>

                        @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        <br>
                        @endif

                        @if($errors->has('login'))
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first('login') }}
                        </div>
                        <br>
                        @endif
                        
                        <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" id="username" class="@error('username') is-invalid @enderror" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">
                                
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password" autofocus placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            @if($errors->has('captcha'))
                            <div class="form-group mt-5">
                            {!! NoCaptcha::renderJs('en', false, 'onloadCallback') !!}
                            {!! NoCaptcha::display(['data-theme' => 'dark']) !!}

                                @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </div>
                            @endif

                            <button type="submit" class="site-btn">Login</button>
                        </form>

                        <div class="text-center">
                        <br>
                        <p>Not registered? <a href="{{ route('register') }}">Register Now</a>!</p>
                        <br>
                            <a href="{{ route('landing') }}"><p><b>Back to Landing Page</b></p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection