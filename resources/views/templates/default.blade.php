<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <title>Chatty</title>
</head>
<body>
    @include('templates.partials.navigation')
    <div class="container">
        @include('templates.partials.alerts')
        @yield('content')
    </div>


</body>
</html>