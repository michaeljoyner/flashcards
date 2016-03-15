<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flashcards</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300|Noto+Sans' rel='stylesheet' type='text/css'>
    @yield('head')
</head>
<body>
    @include('front.partials.navbar')
    @yield('content')
    <script src="/js/main.js"></script>
    @yield('bodyscripts')
</body>
</html>