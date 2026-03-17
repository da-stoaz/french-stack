<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        @php
            $brand = config('brand');
            $headingFont = config('brand.fonts.heading');
            $bodyFont = config('brand.fonts.body');
            $googleFonts = collect([$headingFont, $bodyFont])
                ->filter()
                ->map(fn (string $font) => str_replace(' ', '+', $font).':wght@400;500;600;700')
                ->implode('&family=');
        @endphp

        @if ($googleFonts !== '')
            <link rel="preconnect" href="https://fonts.googleapis.com" />
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
            <link href="https://fonts.googleapis.com/css2?family={{ $googleFonts }}&display=swap" rel="stylesheet" />
        @endif

        <style>
            :root {
                --color-primary: {{ $brand['colors']['primary'] }};
                --color-secondary: {{ $brand['colors']['secondary'] }};
                --color-accent: {{ $brand['colors']['accent'] }};
                --font-heading: '{{ $brand['fonts']['heading'] }}', serif;
                --font-body: '{{ $brand['fonts']['body'] }}', sans-serif;
            }
        </style>

        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.tsx'])
        @inertiaHead
    </head>
    <body class="bg-slate-50 font-body text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        @inertia
    </body>
</html>
