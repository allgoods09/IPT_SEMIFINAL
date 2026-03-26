{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Dashboard' }} — StockFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['DM Sans', 'sans-serif'], mono: ['DM Mono', 'monospace'] },
                    colors: {
                        brand: {
                            50:  '#edfcf4', 100: '#d3f8e4', 200: '#aaf0cc',
                            300: '#73e4ae', 400: '#3acf8a', 500: '#16b36e',
                            600: '#0d9258', 700: '#0b7548', 800: '#0c5e3c',
                            900: '#0b4d32', 950: '#052b1d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f0f4f8; }
        .sidebar-link { transition: all 0.15s ease; border-left: 3px solid transparent; }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(22,179,110,0.12);
            color: #16b36e !important;
            border-left: 3px solid #16b36e;
        }
        .card { background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04); }
        .btn-primary { background: #16b36e; color: white; transition: all 0.15s; }
        .btn-primary:hover { background: #0d9258; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(22,179,110,0.3); }
        .btn-danger { background: #fee2e2; color: #dc2626; transition: all 0.15s; }
        .btn-danger:hover { background: #dc2626; color: white; }
        .badge-active   { background:#dcfce7; color:#15803d; }
        .badge-inactive { background:#f1f5f9; color:#64748b; }
        .table-row:hover { background: #f8fafc; }
        input, select, textarea {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            transition: border-color 0.15s;
            outline: none;
        }
        input:focus, select:focus, textarea:focus { border-color: #16b36e; box-shadow: 0 0 0 3px rgba(22,179,110,0.1); }
        label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; }
        .flash-success { background:#dcfce7; border:1px solid #86efac; color:#166534; padding:12px 16px; border-radius:10px; }
        .flash-error   { background:#fee2e2; border:1px solid #fca5a5; color:#991b1b; padding:12px 16px; border-radius:10px; }
    </style>
</head>
<body class="min-h-screen">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN --}}
    <main class="flex-1 flex flex-col overflow-auto">

        {{-- TOP BAR --}}
        <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between sticky top-0 z-10 ml-64">
            <div>
                <h1 class="text-xl font-bold text-slate-800">{{ $pageTitle ?? 'Dashboard' }}</h1>
                @if (!empty($pageSubtitle))
                    <p class="text-sm text-slate-400 mt-0.5">{{ $pageSubtitle }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-400">{{ now()->format('l, F j, Y') }}</span>
                @isset($headerAction)
                    {{ $headerAction }}
                @endisset
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="flex-1 p-8 ml-64">
            {{ $slot }}
        </div>

    </main>
</div>
</body>
</html>