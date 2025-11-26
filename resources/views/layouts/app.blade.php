<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'My Laravel App')</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen">
<div id="app" class="min-h-screen">
@yield('content')
</div>
</body>
</html>
