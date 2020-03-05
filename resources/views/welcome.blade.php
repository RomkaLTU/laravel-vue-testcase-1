<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Vue Test Case</title>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
    <div id="app">
        <div class="container py-10">
            <upload></upload>
        </div>
    </div>
    </body>
</html>
