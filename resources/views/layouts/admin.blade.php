<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Load Bootstrap và style -->
    <link rel="stylesheet" href="{{ asset('/backend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('/backend/css/style.css') }}">
    <link href="{{ asset('/backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        @include('dashboard_admin.siderbar')
        @include('dashboard_admin.header')
        <div id="page-wrapper" class="gray-bg">

            <div class="wrapper wrapper-content animated fadeIn">
                @yield('content') {{-- Nội dung trang con --}}
            </div>

            {{-- Footer --}}
            @include('dashboard_admin.footer')
        </div>
    </div>
</body>
<script src="{{ asset('/backend/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('/backend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Flot -->
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/flot/jquery.flot.time.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/backend/js/inspinia.js') }}"></script>
<script src="{{ asset('/backend/js/plugins/pace/pace.min.js') }}"></script>

<!-- Sparkline -->
<script src="{{ asset('/backend/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
</html>