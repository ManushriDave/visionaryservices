<!doctype html>
<html lang="en" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title') - Visionary Services</title>

    <meta name="description" content="Do More in Less Time With A Nifty Assistant">


    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="https://niftyassistance.com/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://niftyassistance.com/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://niftyassistance.com/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://niftyassistance.com/images/favicon/site.webmanifest">
<!-- END Icons -->
    @yield('head')
    <!-- Stylesheets -->
    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
    <link rel="stylesheet" id="css-main" href="/assets/frontend/assets/css/codebase.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="/assets/frontend/assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>
<body>
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern ">
        @include('frontend.header')
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                @include('flash::message')
                @yield('content')
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
        @include('frontend.footer')
    </div>
    <!--
                Codebase JS Core

                Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
                to handle those dependencies through webpack. Please check out /assets/frontend/assets/_es6/main/bootstrap.js for more info.

                If you like, you could also include them separately directly from the /assets/frontend/assets/js/core folder in the following
                order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

                /assets/frontend/assets/js/core/jquery.min.js
                /assets/frontend/assets/js/core/bootstrap.bundle.min.js
                /assets/frontend/assets/js/core/simplebar.min.js
                /assets/frontend/assets/js/core/jquery-scrollLock.min.js
                /assets/frontend/assets/js/core/jquery.appear.min.js
                /assets/frontend/assets/js/core/jquery.countTo.min.js
                /assets/frontend/assets/js/core/js.cookie.min.js
            -->
    <script src="/assets/frontend/assets/js/codebase.core.min.js"></script>

    <!--
        Codebase JS

        Custom functionality including Blocks/Layout API as well as other vital and optional helpers
        webpack is putting everything together at /assets/frontend/assets/_es6/main/app.js
    -->
    <script src="/assets/frontend/assets/js/codebase.app.min.js"></script>
    @yield('scripts')
    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->

    <!-- Page JS Code -->
    <script src="/assets/frontend/assets/js/pages/be_forms_plugins.min.js"></script>

    <script>
        $(document).ready(function () {
            $.each($('.nav-main > li'), function () {

                let element = $(this).find('a:first');

                if (window.location.href.includes(element.attr('href'))) {
                    element.addClass('active');
                }
            });

            if (window.location.href.substr(0, window.location.href.length - 1) !== '{{ config('app.url') }}') {
                $('.nav-main > li:first > a:first').removeClass('active');
            }
        });
        $(function(){
            Codebase.helpers([
                'flatpickr',
                'datepsicker',
                'select2',
                'ckeditor'
            ]);
        });
    </script>
</body>
</html>
