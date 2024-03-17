@extends('layouts.app')

@section('content')

    <section class="contact spad">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="contact__map justify-content-center align-items-center">
                    <div class="text-center justify-content-center align-items-center" style="height: 500px, width: 500px">{!! $qrImg !!}</div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="contact__form">
                        <h3>Activate Two Factor Authentication</h3>

                        @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        <br>
                        @endif

                        @if(session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        <br>
                        @endif

                        <p>Set up your two factor authentication by scanning the barcode on the side. Alternatively, you can use the code {{ $secret_key }}</p>
                        <p>You must set up your <b>Google Authenticator</b> app before continuing. You will be unable to login otherwise</p>
                        <br>
                        
                        <form method="POST" action="{{ route('2FA.verify') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="otp_num" id="otp_num" class="@error('otp_num') is-invalid @enderror" value="{{ old('otp_num') }}" required autocomplete="otp_num" autofocus placeholder="OTP Code">
                                
                                @error('otp_num')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <button type="submit" class="site-btn">Activate 2FA</button>
                        </form>

                        @if(session()->has('2FA:user:activated') && session('2FA:user:activated'))
                        @else
                        <div class="text-right">
                        <br>
                            <a href="{{ route('home-no2FA') }}"><p>Set up later</p></a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection