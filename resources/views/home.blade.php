@extends('layouts.app')

@section('content')

    <div class="contact align-items-start">
    <section class="callto spad set-bg" data-setbg="/assets/img/callto-bg.jpg">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8">
                    <div class="callto__text">
                        <h2>Welcome back, <b>{{ auth()->user()->username }}</b>!</h2>
                        <h4>Software Quality Assurance</h4>
                        @if(session()->has('2FA:user:activated') && session('2FA:user:activated'))
                        @else
                        <div class="text-left">
                        <p>You haven't enable <b>Two-Factor Authentication</b>. <br> <a href="{{ route('2FA') }}">Activate now</a></p>
                        </div>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

@endsection