<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
<head>
    <title>Jargas App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/one_jargas_icon.png" type="image/png">
    <link rel="apple-touch-icon" href="/one_jargas_icon.png">

    @fonts
    @routes

    @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    <x-inertia::head>
        <title>{{ config('app.name', 'Laravel') }}</title>
    </x-inertia::head>
</head>
<body class="font-sans antialiased">
<!-- Splash Screen Loading -->
<div id="app-loader"
     style="position: fixed; inset: 0; z-index: 99999; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #0f172a; color: #ffffff; transition: opacity 0.3s ease;">
    <img src="/one_jargas_icon.png" alt="Logo"
         style="width: 64px; height: 64px; margin-bottom: 16px; animation: pulse 1.5s infinite;">
    <div style="font-size: 16px; font-weight: 600; font-family: sans-serif;">Memuat One Jargas</div>
    <div
        style="width: 120px; height: 3px; background: rgba(255,255,255,0.2); margin-top: 16px; border-radius: 3px; overflow: hidden;">
        <div style="width: 40%; height: 100%; background: #38bdf8; animation: loading 1s infinite linear;"></div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.6;
            transform: scale(0.95);
        }
    }

    @keyframes loading {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(250%);
        }
    }
</style>

<x-inertia::app />
</body>
</html>
