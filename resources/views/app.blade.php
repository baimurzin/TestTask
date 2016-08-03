<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="_token" content="<?php echo csrf_token(); ?>">
    <title>DataArmor test app</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:500&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery-comments.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/locale/moment-ru.js') }}"></script>

    @yield('scripts')
</head>
<body>


<div class="container">
    <div class="row clearfix">
        <div class="col-md-12">
            {{--top nav--}}
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>


</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/jquery-comments.js')}}"></script>
<script src="https://npmcdn.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>
<script>
    $(document).ready(function ($e) {
        $('.date').each(function ($e) {
            $(this).html(moment($(this).html()).fromNow());
        });
    });
</script>

</body>
</html>