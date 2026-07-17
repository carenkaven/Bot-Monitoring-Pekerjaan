<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{ 'dark': $store.theme.isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        // Apply dark class to html immediately before render to prevent flicker
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (isDark) document.documentElement.classList.add('dark');
            } catch (e) { }
        })();
    </script>

    <title>Monitoring Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/tailadmin.css') }}">
</head>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
        Alpine.store('theme', {
            isDark: localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches,
            toggle() {
                this.isDark = !this.isDark;
                localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', this.isDark);
            }
        });
    " class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 antialiased h-screen overflow-hidden">
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        @include('layouts.sidebar')
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

            <!-- ===== Header Start ===== -->
            @include('layouts.navbar')
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset

                    {{ $slot ?? '' }}

                    @yield('content')

                </div>
            </main>
            <!-- ===== Main Content End ===== -->

            <!-- Footer -->
            @include('layouts.footer')
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>