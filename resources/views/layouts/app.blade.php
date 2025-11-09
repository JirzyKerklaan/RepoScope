<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'My Laravel App')</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>
<div id="app">
@yield('content')
</div>
</body>
</html>
