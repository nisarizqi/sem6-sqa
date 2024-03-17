@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__item set-bg" data-setbg="/assets/img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <span>Jaminan Mutu Perangkat Lunak</span>
                                <h2>Tugas 1</h2>
                                <a href="{{ route('login') }}" class="primary-btn">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection