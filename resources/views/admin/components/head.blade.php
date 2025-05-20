<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title') - {{ getSetting('website_name') }}</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ getLogoUrl() }}" style="border-radius: 50%;">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ getLogoUrl() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getLogoUrl() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ getLogoUrl() }}">

    <link rel="manifest" href="{{ asset('v1/assets/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('v1/assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">

    <script src="{{ asset('v1/vendors/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('v1/assets/js/config.js') }}"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('v1/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('v1/assets/css/line.css') }}">
    <link href="{{ asset('v1/assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('v1/assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('v1/assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('v1/assets/css/user.min.css') }}" type="text/css" rel="stylesheet" id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
    <link href="{{ asset('v1/vendors/leaflet/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('v1/vendors/leaflet.markercluster/MarkerCluster.css') }}" rel="stylesheet">
    <link href="{{ asset('v1/vendors/leaflet.markercluster/MarkerCluster.Default.css') }}" rel="stylesheet">

    <style>
        /* Add rounded corners to favicon */
        link[rel="icon"],
        link[rel="shortcut icon"],
        link[rel="apple-touch-icon"] {
            border-radius: 8px !important;
        }
    </style>

</head>
