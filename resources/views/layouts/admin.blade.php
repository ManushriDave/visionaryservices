<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') - Admin {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://niftyassistance.com/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://niftyassistance.com/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://niftyassistance.com/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://niftyassistance.com/images/favicon/site.webmanifest">
    
    <link href="/assets/common/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/common/vendor/chartist/css/chartist.min.css">
    @yield('head')
    <link href="/assets/common/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/common/css/style.css" rel="stylesheet">
    <link href="/assets/common/cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

</head>

<body>

<!--*******************
    Preloader start
********************-->
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<!--*******************
    Preloader end
********************-->


<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">

    @include('admin.header')

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!--**********************************
        Content body end
    ***********************************-->

    @include('admin.footer')

</div>
<!--**********************************
    Main wrapper end
***********************************-->

<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="/assets/common/vendor/global/global.min.js"></script>
<script src="/assets/common/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/assets/common/vendor/chart.js/Chart.bundle.min.js"></script>
<script src="/assets/common/js/custom.min.js"></script>
<!-- Apex Chart -->
<script src="/assets/common/vendor/apexchart/apexchart.js"></script>

@yield('scripts')
<!-- Vectormap -->
<!-- Chart piety plugin files -->
<script src="/assets/common/vendor/peity/jquery.peity.min.js"></script>

<!-- Chartist -->
<script src="/assets/common/vendor/chartist/js/chartist.min.js"></script>

<!-- Dashboard 1 -->
<script src="/assets/common/js/dashboard/dashboard-1.js"></script>
<!-- Svganimation scripts -->
<script src="/assets/common/vendor/svganimation/vivus.min.js"></script>
<script src="/assets/common/vendor/svganimation/svg.animation.js"></script>

<script>
    (function($) {
        "use strict"

        var direction =  getUrlParams('dir');
        if(direction !== 'rtl')
        {direction = 'ltr'; }

        new dezSettings({
            typography: "roboto",
            version: "light",
            layout: "vertical",
            headerBg: "color_1",
            navheaderBg: "color_3",
            sidebarBg: "color_1",
            sidebarStyle: "full",
            sidebarPosition: "fixed",
            headerPosition: "fixed",
            containerLayout: "wide",
            direction: direction
        });

    })(jQuery);
</script>
</body>

</html>
