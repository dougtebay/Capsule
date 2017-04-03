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
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <app app_name="{{ config('app.name') }}"
             csrf_token="{{ csrf_token() }}"
             user_json="{{ auth()->user() }}">
        </app>
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>