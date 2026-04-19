<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Antigravity POS') }} - @yield('title', 'Dashboard')</title>
        <meta name="description" content="Antigravity POS - Aplikasi Point of Sales Modern">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-400" x-data="{ sidebarOpen: true, mobileSidebar: false }">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 ease-in-out"
                   :class="sidebarOpen ? 'w-64' : 'w-20'"
                   x-cloak>
                <!-- Sidebar Background -->
                <div class="absolute inset-0 bg-white/80 backdrop-blur-xl border-r border-slate-200/80"></div>

                <div class="relative flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center h-16 px-4 border-b border-slate-200/80">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-violet-500/25">
                                <svg class="w-6 h-6 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="font-bold text-lg bg-gradient-to-r from-violet-400 to-indigo-400 bg-clip-text text-transparent transition-opacity duration-300"
                                  :class="sidebarOpen ? 'opacity-100' : 'opacity-0 hidden'">
                                POS
                            </span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Dashboard</span>
                        </a>

                        <a href="{{ route('pos.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('pos.*') ? 'bg-emerald-500/20 text-emerald-300 shadow-lg shadow-emerald-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Kasir</span>
                        </a>

                        <a href="{{ route('orders.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('orders.*') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Pesanan</span>
                        </a>

                        @if(auth()->user()->isAdmin())
                        <div class="pt-4 pb-2" x-show="sidebarOpen">
                            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Admin</p>
                        </div>

                        <a href="{{ route('products.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Produk</span>
                        </a>

                        <a href="{{ route('categories.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Kategori</span>
                        </a>

                        <a href="{{ route('customers.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('customers.*') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Pelanggan</span>
                        </a>

                        <a href="{{ route('reports.index') }}"
                           class="nav-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-violet-500/20 text-violet-300 shadow-lg shadow-violet-500/10' : 'text-slate-400 hover:text-slate-400 hover:bg-slate-100/50' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span :class="sidebarOpen ? '' : 'hidden'">Laporan</span>
                        </a>
                        @endif
                    </nav>

                    <!-- User Section -->
                    <div class="px-3 py-4 border-t border-slate-200/80">
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-slate-800 font-semibold text-sm flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0" x-show="sidebarOpen">
                                <p class="text-sm font-medium text-slate-400 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen">
                                @csrf
                                <button type="submit" class="text-slate-400 hover:text-rose-400 transition-colors" title="Logout">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-20'">
                <!-- Top Bar -->
                <header class="sticky top-0 z-40 h-16 flex items-center justify-between px-6 bg-slate-50/80 backdrop-blur-xl border-b border-slate-200/80">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-slate-400 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-lg font-semibold text-slate-800">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-400">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-6">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-transition>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                        <button @click="show = false" class="ml-auto text-emerald-500 hover:text-emerald-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="mb-6 px-4 py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center gap-2" x-data="{ show: true }" x-show="show" x-transition>
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                        <button @click="show = false" class="ml-auto text-rose-500 hover:text-rose-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
