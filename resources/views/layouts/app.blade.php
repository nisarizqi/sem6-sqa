<!DOCTYPE html>
<html>

    <head>
        @include('partition.head')

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        @yield('content')

            <!-- Js Plugins -->
        <script src="{{ asset('/assets/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('/assets/js/mixitup.min.js') }}"></script>
        <script src="{{ asset('/assets/js/masonry.pkgd.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.slicknav.js') }}"></script>
        <script src="{{ asset('/assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('/assets/js/main.js') }}"></script>
    </body>

</html>