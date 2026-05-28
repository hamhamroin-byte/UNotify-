<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "ddb92b6a-983d-4197-b7ea-1d64820989bc",
                notifyButton: {
                    enable: true, // Memunculkan tombol lonceng kecil di pojok kanan bawah screen
                    size: 'medium',
                    theme: 'default',
                    position: 'bottom-right',
                },
            });
        });
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-[#0B192C] via-[#1E3E62] to-[#00D2FC]">
        
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white/10 backdrop-blur-md shadow border-b border-white/10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="text-white font-semibold">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>