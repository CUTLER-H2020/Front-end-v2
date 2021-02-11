<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="tr">
<!--<![endif]-->

<head>
    <meta charset="utf-8"/>
    <title>@yield('title') - Cutler Lite</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="author"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="{{ admin_asset('global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ admin_asset('global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ admin_asset('global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ admin_asset('global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ admin_asset('global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ admin_asset('global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ admin_asset('global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ admin_asset('global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ admin_asset('global/css/components-md.css?v=1.5') }}" rel="stylesheet" id="style_components"
          type="text/css"/>
    <link href="{{ admin_asset('global/css/plugins-md.css') }}" rel="stylesheet" type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ admin_asset('layouts/layout4/css/layout.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ admin_asset('layouts/layout4/css/themes/default.min.css') }}" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="{{ admin_asset('layouts/layout4/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>
    <style>ul.breadcrumb li span.active {
            font-weight: bold !important;
            color: #3598dc;
        }</style>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        <div class="page-logo">
            <a href="{{ route('policy.index') }}">
                <img src="{{ admin_asset('pages/img/cutler-logo.png') }}" alt="logo" class="logo-default"
                     style="margin-top: 15px"/>
            </a>
            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-language">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            {{--                            <img alt="" src="{{ admin_asset('global/img/flags/us.png') }}">--}}
                            <span class="langname"> {{ trans('translation.general.language') }} </span>
                            &nbsp;
                            @if($siteLanguages->count() > 0)
                                @foreach($siteLanguages as $tempLanguage)
                                    @if($tempLanguage->code==\App::getLocale())
                                        @if($tempLanguage->status==1)
                                            <img alt=""
                                                 src="{{ admin_asset('global/img/flags/'.$tempLanguage->icon) }}">
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @if($siteLanguages->count() > 0)
                                @foreach($siteLanguages as $tempLanguage)
                                    @if($tempLanguage->status==1)
                                        <li>
                                            <a href="{{ route('locale', $tempLanguage->code) }}">
                                                <img alt=""
                                                     src="{{ admin_asset('global/img/flags/'.$tempLanguage->icon) }}"> {{ trans('translation.language.'.$tempLanguage->code) }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user dropdown-dark">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <span
                                class="username username-hide-on-mobile"> {{ Auth::user()->name.' '. Auth::user()->surname }} </span>
                        <!--<img alt="" class="img-circle" src="{{ admin_asset('layouts/layout4/img/avatar9.jpg') }}" />-->
                            <i class="  icon-settings"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{ route('change-password') }}">
                                    <i class="fa fa-refresh"></i>{{ trans('translation.general.change-password') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i> {{ trans('translation.general.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="page-container">
    @yield('sidebar')

    @yield('content')
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> 2020 Cutler-v1</div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!--[if lt IE 9]>
<script src="{{ admin_asset('global/plugins/respond.min.js') }}"></script>
<script src="{{ admin_asset('global/plugins/excanvas.min.js') }}"></script>
<script src="{{ admin_asset('global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ admin_asset('global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
        type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
        type="text/javascript"></script>
@yield('js')
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ admin_asset('global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
{{--<script src="{{ admin_asset('global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/pie.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/ammap/ammap.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/amcharts/amstockcharts/amstock.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/horizontal-timeline/horizontal-timeline.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>--}}
{{--<script src="{{ admin_asset('global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript"></script>--}}
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ admin_asset('global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ admin_asset('pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ admin_asset('layouts/layout4/scripts/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('layouts/layout4/scripts/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ admin_asset('layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $('.delete-button').on('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: '{{ trans('translation.general.sure') }}',
            text: '{{ trans('translation.general.cannot') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ trans('translation.general.delete-this') }}',
            cancelButtonText: '{{ trans('translation.general.cancel') }}'
        }).then((result) => {
            if (result.value) {
                window.location.href = $(this).attr('href');
            }
        });
    });

    $('.disabled-button').on('click', function () {
        $(this).attr('disabled', true).addClass('disabled');
        window.location.href = $(this).attr('href');
    })
</script>
</body>
</html>
