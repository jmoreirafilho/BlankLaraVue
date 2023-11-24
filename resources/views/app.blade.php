<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='/css/material_fonts.css' rel="stylesheet">
    <title>{{ config('app.name', 'BlankLaraVue') }}</title>
    
    <link rel="manifest" href="/manifest.json" />
    <meta name="theme-color" content="white">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ config('app.name', 'BlankLaraVue') }}">
    <link rel="icon" href="/images/icone.png">
    <meta name="msapplication-TileImage" content="/images/icone.png">
    <meta name="msapplication-TileColor" content="#000">
    <!-- Apple -->
    <link rel="apple-touch-icon" href="/images/icone.png">
    <link rel="apple-touch-icon" sizes="36x36" href="/images/logos/logo_36.png">
    <link rel="apple-touch-icon" sizes="48x48" href="/images/logos/logo_48.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/logos/logo_72.png">
    <link rel="apple-touch-icon" sizes="96x96" href="/images/logos/logo_96.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/logos/logo_144.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/images/logos/logo_192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0476F2">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'BlankLaraVue') }}">

    <link href="/css/app.css" rel="stylesheet">
</head>
<body>

    <div id="app">
        <v-app app>
            <router-view></router-view>
        </v-app>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('sw.js');
            });
        }
    </script>
</body>
</html>