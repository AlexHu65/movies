<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Movies - App </title>
    @include('shared.assets')
</head>
<body>

    <main>
        @yield('main')
    </main>

    @include('shared.scripts')

    @if(isset($action) && isset($section))
        <script>
            let action = '{{ $action ?? $action }}'
            let section = '{{ $section ?? $section }}'
        </script>
    @endif
    
</body>
</html>