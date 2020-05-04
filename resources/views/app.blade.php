<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="HandheldFriendly" content="true"/>

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,400,600" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="root">
        <router-view></router-view>
    </div>

    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
