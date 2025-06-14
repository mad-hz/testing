<!DOCTYPE html>
<html lang="en" data-theme="light">
@stack('styles')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Syntess</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    @if(session('success')) data-toast-message="{{ session('success') }}" data-toast-type="success"
    @elseif(session('error')) data-toast-message="{{ session('error') }}" data-toast-type="error"
    @elseif(session('warning')) data-toast-message="{{ session('warning') }}" data-toast-type="warning"
    @elseif(session('info')) data-toast-message="{{ session('info') }}" data-toast-type="info"
    @endif
>
<x-navbar :article="$article ?? ''"/>

<div class="sm:ml-64">
    {{ $slot }}
</div>
</body>

@stack('scripts')
</html>
