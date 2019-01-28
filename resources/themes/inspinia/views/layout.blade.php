<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INSPINIA | Dashboard</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('css/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <script>
        let APP = {
            csrf: {
                token: '{{ csrf_token() }}'
            }
        };
    </script>
</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            @include('partials.navigation')
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            @include('partials.header')
        </div>

        @yield('main-heading')

        @yield('content')

        <div class="footer">
            <div class="float-right">

            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2018
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendor.js') }}"></script>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/pace.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>

<!-- GITTER -->
<script src="{{ asset('js/jquery.gritter.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

@yield('scripts')

<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

</body>
</html>
