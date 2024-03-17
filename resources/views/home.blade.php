@extends('layouts.app')

@section('content')

    <div class="contact align-items-start">
    <section class="callto spad set-bg" data-setbg="/assets/img/callto-bg.jpg">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-8">
                    <div class="callto__text">
                        <h2>Welcome back, <b>{{ auth()->user()->username }}</b>!</h2>
                        <p>Software Quality Assurance</p>
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