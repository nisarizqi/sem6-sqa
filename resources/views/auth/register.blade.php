@extends('layouts.app')

@section('content')

    <section class="contact spad">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__map set-bg" data-setbg="/assets/img/hero/hero-1.jpg">
                        
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <h3>Create an account</h3>
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
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
                                <input type="email" name="email" id="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="new-password" autofocus placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="@error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="new-password" autofocus placeholder="Confirm Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div class="form-group">
                            <button type="submit" class="site-btn">Register</button>
                        </form>
                        <br>
                        <div class="text-center">
                            <p>Already registered? <a href="{{ route('login') }}">Login</a>!</p>
                            <br>
                            <a href="{{ route('landing') }}"><p><b>Back to Landing Page</b></p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection