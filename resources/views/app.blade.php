<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'apiToken' => auth()->user() ? auth()->user()->api_token : '',
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <app app_name="{{ config('app.name') }}"
             user_json="{{ auth()->user() }}"
             request_uri="{{ session('requestUri') }}">
        </app>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
