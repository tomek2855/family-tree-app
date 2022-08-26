<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Family Tree')
    </title>

    @vite('resources/js/app.js')
</head>

<body class="antialiased">
    <div class="container mx-auto p-8">
        <div class="grid grid-cols-12 gap-6">
            <aside class="col-span-3">
                @include('sidebar')
            </aside>
            <section class="col-span-9">
                @yield('content')
            </section>
        </div>
    </div>
</body>

</html>
