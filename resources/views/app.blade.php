<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ogi - BlackJack - {{ date('Y') }}</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="/assets/timer.js"></script>
    <link rel="stylesheet" href="/assets/blackjack.css">
</head>
<body>
    <div>
        @yield('content')
    </div>
</body>
    @yield('footer')
</html>
