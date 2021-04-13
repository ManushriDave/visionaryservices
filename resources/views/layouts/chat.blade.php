<!doctype html>
<html lang="en" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chat - Visionary Services</title>

    <meta name="description" content="Do More in Less Time With A Nifty Assistant">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Nifty Assistant">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description" content="Do More in Less Time With A Nifty Assistant">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="/assets/frontend/assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/frontend/assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/frontend/assets/media/favicons/apple-touch-icon-180x180.png">
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
    <div id="app">
        <div id="page-container">
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
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/assets/frontend/assets/js/codebase.core.min.js"></script>

    <!--
        Codebase JS

        Custom functionality including Blocks/Layout API as well as other vital and optional helpers
        webpack is putting everything together at /assets/frontend/assets/_es6/main/app.js
    -->
    <script src="/assets/frontend/assets/js/codebase.app.min.js"></script>
    <!-- Page JS Code -->
    <script src="/assets/frontend/assets/js/pages/be_comp_chat_alt.min.js"></script>
    @yield('scripts')
</body>
</html>
