{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow — Inventory Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,300;1,9..40,400&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'DM Sans', sans-serif; }

        :root {
            --green: #16b36e;
            --dark: #0d1b2a;
            --dark2: #0a1520;
        }

        body { background: var(--dark); color: #fff; overflow-x: hidden; }

        .grid-bg {
            background-image:
                linear-gradient(rgba(22,179,110,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(22,179,110,0.06) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
        }

        .navbar {
            background: rgba(13,27,42,0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .btn-outline {
            border: 1.5px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            padding: 9px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
            background: transparent;
        }
        .btn-outline:hover { border-color: var(--green); color: var(--green); }

        .btn-green {
            background: var(--green);
            color: white;
            padding: 9px 22px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }
        .btn-green:hover {
            background: #0d9258;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(22,179,110,0.35);
        }

        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            padding: 32px;
            transition: all 0.3s;
        }
        .feature-card:hover {
            background: rgba(22,179,110,0.05);
            border-color: rgba(22,179,110,0.2);
            transform: translateY(-4px);
        }

        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
            z-index: 50;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-box {
            background: #0f2035;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
        }
        .modal-input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 12px 14px;
            color: white;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .modal-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,179,110,0.1); }
        .modal-input::placeholder { color: rgba(255,255,255,0.3); }
        select.modal-input option { background: #0f2035; color: white; }
        .modal-label { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: block; }
        .modal-submit { width: 100%; background: var(--green); color: white; padding: 13px; border-radius: 10px; font-weight: 700; font-size: 15px; border: none; cursor: pointer; transition: all 0.2s; }
        .modal-submit:hover { background: #0d9258; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(22,179,110,0.35); }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(22,179,110,0.1);
            border: 1px solid rgba(22,179,110,0.25);
            padding: 6px 14px; border-radius: 100px;
            font-size: 13px; font-weight: 600; color: var(--green);
        }

        .grad-text {
            background: linear-gradient(135deg, #ffffff 0%, #16b36e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        .mockup {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            overflow: hidden;
        }
        .mockup-bar { background: rgba(255,255,255,0.05); padding: 12px 20px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar sticky top-0 z-40 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:var(--green);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="font-bold text-lg text-white">StockFlow</span>
        </div>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium" style="color:rgba(255,255,255,0.5);">
            <a href="#features" class="hover:text-white transition">Features</a>
            <a href="#how" class="hover:text-white transition">How it works</a>
            <a href="#stats" class="hover:text-white transition">Overview</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-outline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-green">Logout</button>
                </form>
            @else
                <button class="btn-outline" onclick="openModal('login')">Sign In</button>
                <button class="btn-green" onclick="openModal('register')">Get Started</button>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="grid-bg relative min-h-screen flex items-center justify-center px-6 pt-10 pb-24">
    <div class="orb w-96 h-96" style="background:rgba(22,179,110,0.15); top:-100px; left:-100px;"></div>
    <div class="orb w-80 h-80" style="background:rgba(22,179,110,0.08); bottom:0; right:-80px;"></div>

    <div class="max-w-6xl mx-auto w-full relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div>
                <div class="hero-badge mb-6">
                    <span style="width:7px;height:7px;background:var(--green);border-radius:50%;display:inline-block;"></span>
                    Built for Philippine businesses
                </div>
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Inventory that<br>
                    <span class="grad-text">works as hard</span><br>
                    as you do.
                </h1>
                <p class="text-lg mb-10" style="color:rgba(255,255,255,0.55); max-width:420px; line-height:1.7;">
                    Track products, manage categories, record sales, and control your team — all from one clean dashboard.
                </p>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-green text-base px-7 py-3.5">Go to Dashboard →</a>
                    @else
                        <button class="btn-green text-base px-7 py-3.5" onclick="openModal('register')">Start for free →</button>
                        <button class="btn-outline text-base px-7 py-3.5" onclick="openModal('login')">Sign in</button>
                    @endauth
                </div>
                <p class="mt-5 text-xs" style="color:rgba(255,255,255,0.25);">Default admin: admin@gmail.com / password</p>
            </div>

            <!-- Right: Dashboard mockup (static) -->
            <div class="mockup shadow-2xl">
                <div class="mockup-bar">
                    <div class="dot" style="background:#ff5f57;"></div>
                    <div class="dot" style="background:#febc2e;"></div>
                    <div class="dot" style="background:#28c840;"></div>
                    <span class="ml-3 text-xs" style="color:rgba(255,255,255,0.3);">StockFlow Dashboard</span>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-3 gap-3">
                        @foreach ([['Revenue','₱48,918.54','#16b36e'], ['Products','845','#3b82f6'], ['Sales','4951','#8b5cf6']] as [$label, $value, $color])
                        <div class="rounded-xl p-3" style="background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.07);">
                            <div class="text-xs mb-1" style="color:rgba(255,255,255,0.4);">{{ $label }}</div>
                            <div class="text-xl font-bold" style="color:{{ $color }};">{{ $value }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="rounded-xl overflow-hidden" style="border:1px solid rgba(255,255,255,0.07);">
                        <div class="px-4 py-2.5 text-xs font-semibold flex justify-between" style="background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.4);">
                            <span>PRODUCT</span><span>STOCK</span><span>STATUS</span>
                        </div>
                        @foreach ([['Wireless Mouse',24],['USB Hub',6],['Keyboard',18],['Monitor',3]] as [$name, $stock])
                        <div class="px-4 py-2.5 flex justify-between items-center text-sm" style="border-top:1px solid rgba(255,255,255,0.05);">
                            <span style="color:rgba(255,255,255,0.8);">{{ $name }}</span>
                            <span style="color:{{ $stock < 10 ? '#f87171' : 'rgba(255,255,255,0.5)' }}; font-weight:600;">{{ $stock }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full font-semibold" style="background:rgba(22,179,110,0.15); color:#16b36e;">Active</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="space-y-2.5">
                        @foreach ([['Electronics',78,'#16b36e'],['Peripherals',52,'#3b82f6'],['Accessories',34,'#8b5cf6']] as [$label, $pct, $color])
                        <div>
                            <div class="flex justify-between text-xs mb-1" style="color:rgba(255,255,255,0.4);">
                                <span>{{ $label }}</span><span>{{ $pct }}%</span>
                            </div>
                            <div class="rounded-full h-1.5" style="background:rgba(255,255,255,0.07);">
                                <div class="h-1.5 rounded-full" style="width:{{ $pct }}%; background:{{ $color }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="px-6 py-24" style="background:rgba(0,0,0,0.2);">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 fade-up">
            <div class="hero-badge mb-4" style="display:inline-flex;">Everything you need</div>
            <h2 class="text-4xl font-bold mt-2">Built for real inventory work</h2>
            <p class="mt-4 text-lg" style="color:rgba(255,255,255,0.45);">No bloat. Just the tools that matter.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $features = [
                ['M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', '#16b36e', 'Product Management', 'Add, edit, categorize, and track every SKU with reorder level alerts.'],
                ['M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z', '#3b82f6', 'Sales Recording', 'Log transactions instantly with quantity, pricing, and payment method.'],
                ['M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', '#f59e0b', 'Smart Categories', 'Organize your catalog so products are always easy to find and filter.'],
                ['M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', '#8b5cf6', 'Role-Based Access', 'Admins control everything. Staff can view and record sales — nothing more.'],
                ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', '#ef4444', 'Live Dashboard', 'See revenue, stock levels, and low-stock alerts the moment you open the app.'],
                ['M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', '#16b36e', 'Reorder Alerts', 'Never run out. Get visual warnings when stock drops below your set minimum.'],
            ];
            @endphp
            @foreach ($features as $i => [$icon, $color, $title, $desc])
            <div class="feature-card fade-up" style="transition-delay: {{ $i * 80 }}ms">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5" style="background:{{ $color }}18;">
                    <svg class="w-6 h-6" style="color:{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ $title }}</h3>
                <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.45);">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section id="how" class="px-6 py-24">
    <div class="max-w-4xl mx-auto text-center">
        <div class="hero-badge mb-4" style="display:inline-flex;">Simple by design</div>
        <h2 class="text-4xl font-bold mt-2 mb-16 fade-up">Up and running in minutes</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ([
                ['01', 'Create your account', 'Register as Admin or Staff and log in immediately.'],
                ['02', 'Add your products', 'Set up categories first, then add products with pricing and stock counts.'],
                ['03', 'Start selling', 'Record every sale in seconds. The dashboard updates in real time.'],
            ] as $i => [$num, $title, $desc])
            <div class="fade-up" style="transition-delay:{{ $i * 100 }}ms;">
                <div class="text-6xl font-black mb-4" style="color:rgba(22,179,110,0.15); letter-spacing:-2px;">{{ $num }}</div>
                <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
                <p class="text-sm leading-relaxed" style="color:rgba(255,255,255,0.45);">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="px-6 py-24">
    <div class="max-w-3xl mx-auto text-center fade-up">
        <h2 class="text-4xl font-bold mb-4">Ready to take control of your inventory?</h2>
        <p class="mb-10 text-lg" style="color:rgba(255,255,255,0.45);">Join your team on StockFlow and start managing smarter today.</p>
        <div class="flex items-center justify-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-green text-base px-8 py-4">Go to Dashboard →</a>
            @else
                <button class="btn-green text-base px-8 py-4" onclick="openModal('register')">Create free account →</button>
                <button class="btn-outline text-base px-8 py-4" onclick="openModal('login')">Sign in</button>
            @endauth
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="border-t px-6 py-8" style="border-color:rgba(255,255,255,0.06);">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background:var(--green);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="font-bold text-sm">StockFlow</span>
        </div>
        <p class="text-xs" style="color:rgba(255,255,255,0.25);">© {{ date('Y') }} StockFlow. Product Inventory System.</p>
    </div>
</footer>

<!-- LOGIN MODAL -->
<div id="modal-login" class="modal-backdrop" style="display:none;">
    <div class="modal-box">
        <button onclick="closeModal()" class="absolute top-5 right-5 text-2xl leading-none" style="color:rgba(255,255,255,0.3); background:none; border:none; cursor:pointer;">×</button>
        <div class="flex items-center gap-2 mb-7">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:var(--green);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="font-bold">StockFlow</span>
        </div>
        <h2 class="text-2xl font-bold mb-1">Welcome back</h2>
        <p class="text-sm mb-7" style="color:rgba(255,255,255,0.4);">Sign in to your account</p>

        @if ($errors->has('email'))
        <div class="mb-5 p-3 rounded-xl text-sm" style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#f87171;">
            {{ $errors->first('email') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="modal-label">Email</label>
                <input class="modal-input" type="email" name="email" placeholder="admin@gmail.com" value="{{ old('email') }}" required>
            </div>
            <div>
                <label class="modal-label">Password</label>
                <input class="modal-input" type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="modal-submit mt-2">Sign In</button>
        </form>
        <p class="text-center text-sm mt-5" style="color:rgba(255,255,255,0.35);">
            No account? <button onclick="switchModal('register')" class="font-semibold" style="color:var(--green); background:none; border:none; cursor:pointer;">Get started</button>
        </p>
    </div>
</div>

<!-- REGISTER MODAL -->
<div id="modal-register" class="modal-backdrop" style="display:none;">
    <div class="modal-box">
        <button onclick="closeModal()" class="absolute top-5 right-5 text-2xl leading-none" style="color:rgba(255,255,255,0.3); background:none; border:none; cursor:pointer;">×</button>
        <div class="flex items-center gap-2 mb-7">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:var(--green);">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="font-bold">StockFlow</span>
        </div>
        <h2 class="text-2xl font-bold mb-1">Create account</h2>
        <p class="text-sm mb-7" style="color:rgba(255,255,255,0.4);">Join your team on StockFlow</p>

        @if ($errors->any() && !$errors->has('email'))
        <div class="mb-5 p-3 rounded-xl text-sm" style="background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.3); color:#f87171;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="modal-label">Full Name</label>
                <input class="modal-input" type="text" name="name" placeholder="Juan Dela Cruz" value="{{ old('name') }}" required>
            </div>
            <div>
                <label class="modal-label">Email</label>
                <input class="modal-input" type="email" name="email" placeholder="you@email.com" value="{{ old('email') }}" required>
            </div>
            <div>
                <label class="modal-label">Password</label>
                <input class="modal-input" type="password" name="password" placeholder="••••••••" required>
            </div>
            <div>
                <label class="modal-label">Confirm Password</label>
                <input class="modal-input" type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
            <button type="submit" class="modal-submit mt-2">Create Account</button>
        </form>
        <p class="text-center text-sm mt-5" style="color:rgba(255,255,255,0.35);">
            Already have an account? <button onclick="switchModal('login')" class="font-semibold" style="color:var(--green); background:none; border:none; cursor:pointer;">Sign in</button>
        </p>
    </div>
</div>

<script>
    function openModal(type) {
        document.getElementById('modal-' + type).style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        document.querySelectorAll('.modal-backdrop').forEach(m => m.style.display = 'none');
        document.body.style.overflow = '';
    }
    function switchModal(type) {
        closeModal();
        setTimeout(() => openModal(type), 50);
    }

    window.addEventListener('DOMContentLoaded', () => {
        openModal('register');
    });

    document.querySelectorAll('.modal-backdrop').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) closeModal(); });
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    // Re-open modal on validation error so user sees the message
    @if ($errors->has('email'))
        openModal('login');
    @elseif ($errors->any())
        openModal('register');
    @endif

    // Scroll fade-in
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector(a.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
        });
    });
</script>
</body>
</html>