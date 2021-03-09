<!DOCTYPE html>
<html class="no-js" lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://www.facebook.com">
    <link rel="preconnect" href="https://connect.facebook.net">
    <link rel="preconnect" href="https://www.google-analytics.com">

    <title>Cheeky Scientist Resume Builder</title>
    <meta name="description" content="Build your resume and get a job">

    <link rel="canonical" href="{{ request()->url() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">

    {{-- Open Graph  --}}
    <meta property="og:title" content="Cheeky Scientist Resume Builder">
    <meta property="og:description" content="Build your resume and get a job">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/images/open-graph/open-graph-default.png') }}">
    {{-- <meta property="og:image:width" content="1200"> --}}
    {{-- <meta property="og:image:height" content="629"> --}}

    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="Cheeky Scientist">

    {{-- favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/favicons/safari-pinned-tab.svg') }}" color="#002b49">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicons/favicon.ico') }}">
    <meta name="apple-mobile-web-app-title" content="Cheeky Scientist">
    <meta name="application-name" content="Cheeky Scientist">
    <meta name="msapplication-TileColor" content="#002b49">
    <meta name="msapplication-config" content="{{ asset('assets/images/favicons/browserconfig.xml') }}">
    <meta name="theme-color" content="#002b49">

    @include('partials.tracking_scripts')
</head>
<body>

    @include('partials.tracking_noscripts')
    @include('partials.standard_header')

    <main id="app">
        @include('partials.flash_messages')
        @yield('content')
    </main>

    @include('partials.standard_footer')
    @include('partials.legal_footer')

    <script async src="{{ mix('assets/js/app.js') }}"></script>
    <script async src="{{ mix('assets/js/fontawesome.js') }}"></script>

    @stack('scripts')
    @include('partials.tracking_scripts_footer')

    <script type="text/javascript">
    (function(w,d){
    w.HelpCrunch=function(){w.HelpCrunch.q.push(arguments)};w.HelpCrunch.q=[];
    function r(){var s=document.createElement('script');s.async=1;s.type='text/javascript';s.src='https://widget.helpcrunch.com/';(d.body||d.head).appendChild(s);}
    if(w.attachEvent){w.attachEvent('onload',r)}else{w.addEventListener('load',r,false)}
    })(window, document)
    </script>

    <script type="text/javascript">
    HelpCrunch('init', 'cheekyscientist', {
        applicationId: 1,
        applicationSecret: 'PlSBnd33l3Oc0ymn9huyp9DXimpzbU0key9JaCpbROsO/j+FfgBfzXiSaRIJeqRXh6jVTH52HuNpK8pDU5I0lw=='
    })

    HelpCrunch('showChatWidget');
    </script>
</body>
</html>
