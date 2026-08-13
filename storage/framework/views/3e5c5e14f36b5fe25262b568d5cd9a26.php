<header
  class="sticky top-0 z-40 flex w-full border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 transition-colors duration-300">
  <div class="flex flex-grow items-center justify-between px-4 py-3 md:px-6 2xl:px-11">

    <!-- Mobile Hamburger & Logo -->
    <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
      <!-- Hamburger Toggle BTN -->
      <button
        class="z-50 block rounded-lg border border-gray-200 bg-white p-2 shadow-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 lg:hidden"
        @click.stop="sidebarToggle = !sidebarToggle">
        <span class="relative block h-5 w-5 cursor-pointer">
          <span class="du-block absolute right-0 h-full w-full">
            <span
              class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white"
              :class="{'!w-full delay-300': !sidebarToggle}"></span>
            <span
              class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white"
              :class="{'!w-full delay-400': !sidebarToggle}"></span>
            <span
              class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white"
              :class="{'!w-full delay-500': !sidebarToggle}"></span>
          </span>
          <span class="absolute right-0 h-full w-full rotate-45">
            <span
              class="absolute left-2.5 top-0 block h-full w-0.5 rounded-sm bg-black delay-300 duration-200 ease-in-out dark:bg-white"
              :class="{'!h-0 !delay-[0]': !sidebarToggle}"></span>
            <span
              class="delay-400 absolute left-0 top-2.5 block h-0.5 w-full rounded-sm bg-black duration-200 ease-in-out dark:bg-white"
              :class="{'!h-0 !delay-200': !sidebarToggle}"></span>
          </span>
        </span>
      </button>

      <!-- Logo for Mobile -->
      <a class="block flex-shrink-0 lg:hidden" href="<?php echo e(route('dashboard')); ?>">
        <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
          RAS
        </div>
      </a>
    </div>

    <!-- Hidden Search Bar (Optional to add later) / Space filler -->
    <div class="hidden sm:block"></div>

    <div class="flex items-center gap-3 2xsm:gap-5">
      <ul class="flex items-center gap-2 2xsm:gap-4">

        <!-- Dark Mode Toggler -->
        <li>
          <button
            class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 text-gray-500 dark:text-gray-300 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
            @click.prevent="$store.theme.toggle()">
            <!-- Sun Icon (shows when dark) -->
            <svg x-show="$store.theme.isDark" class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" x-cloak>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>

            <!-- Moon Icon (shows when light) -->
            <svg x-show="!$store.theme.isDark" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" x-cloak>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
          </button>
        </li>


     <!-- Notification Menu Area -->
<li class="relative"
    x-data="{ dropdownOpen: false }"
    @click.outside="dropdownOpen = false">

    <button
        @click.prevent="dropdownOpen = !dropdownOpen"
        class="relative flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800">

        <?php if($notifCount > 0): ?>
            <span
                class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-600 px-1 text-[10px] font-bold text-white">
                <?php echo e($notifCount); ?>

            </span>
        <?php endif; ?>

        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
            <path
                d="M11.9991 3.25C8.01693 3.25 4.74915 6.51778 4.74915 10.5V13.8826C4.74915 14.7335 4.41144 15.5496 3.81057 16.1505L3.63002 16.331C3.1257 16.8353 3.48316 17.6973 4.19665 17.6973H8.38466C8.80373 19.3496 10.2644 20.6033 11.9991 20.6033C13.7339 20.6033 15.1945 19.3496 15.6136 17.6973H19.8016C20.5151 17.6973 20.8726 16.8353 20.3683 16.331L20.1877 16.1505C19.5868 15.5496 19.2491 14.7335 19.2491 13.8826V10.5C19.2491 6.51778 15.9813 3.25 11.9991 3.25Z"/>
        </svg>
    </button>

    <!-- Dropdown -->
    <div
        x-show="dropdownOpen"
        x-transition
        x-cloak
        class="absolute right-0 mt-3 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900">

        <div class="border-b px-4 py-3">
            <h3 class="font-semibold text-gray-800 dark:text-white">
                Notifikasi
            </h3>
        </div>

        <div class="max-h-96 overflow-y-auto">

            <?php $__empty_1 = true; $__currentLoopData = $notifLaporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <a href="<?php echo e(route('laporan.show', $laporan->id)); ?>"
                   class="block border-b px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800">

                    <div class="font-semibold text-gray-800 dark:text-white">
                        📋 Laporan Baru
                    </div>

                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        <?php echo e($laporan->karyawan->nama); ?>

                    </div>

                    <div class="text-xs text-gray-500">
                        <?php echo e($laporan->pekerjaan); ?>

                    </div>

                    <div class="mt-1 text-xs text-blue-600">
                        <?php echo e(\Carbon\Carbon::parse($laporan->tanggal)->format('d M Y')); ?>

                    </div>

                </a>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="p-6 text-center text-gray-500">
                    Tidak ada laporan yang menunggu verifikasi.
                </div>

            <?php endif; ?>

        </div>

        <?php if($notifCount > 0): ?>
            <div class="border-t bg-gray-50 px-4 py-2 text-center text-sm dark:bg-gray-800">
                Total <?php echo e($notifCount); ?> laporan menunggu verifikasi
            </div>
        <?php endif; ?>

    </div>

</li>

      <!-- User Area -->
      <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
        <a class="flex items-center gap-4 text-gray-700 dark:text-gray-400" href="#"
          @click.prevent="dropdownOpen = ! dropdownOpen">
          <span class="hidden text-right lg:block">
            <span class="block text-sm font-medium text-black dark:text-white">
              <?php echo e(Auth::user()->name); ?>

            </span>
            <span class="block text-xs text-gray-500">
              <?php echo e(Auth::user()->isAdmin() ? 'Administrator' : 'Karyawan'); ?>

            </span>
          </span>

          <span
            class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm">
            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

          </span>

          <svg class="hidden sm:block fill-current sm:w-3 sm:h-3" :class="dropdownOpen && 'rotate-180'"
            viewBox="0 0 12 8" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1.5L6 6.5L11 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </a>

        <!-- User Dropdown -->
        <div x-show="dropdownOpen" x-cloak
          class="absolute right-0 mt-3 flex w-56 flex-col rounded-xl border border-gray-200 bg-white shadow-xl dark:border-gray-800 dark:bg-gray-900 transition-all">
          <ul class="flex flex-col gap-1 border-b border-gray-200 p-2 dark:border-gray-800">
            <li>
              <a href="<?php echo e(route('profile.edit')); ?>"
                class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profil Akun
              </a>
            </li>
          </ul>

          <form action="<?php echo e(route('logout')); ?>" method="POST" class="p-2">
            <?php echo csrf_field(); ?>
            <button type="submit"
              class="flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 dark:hover:bg-red-900/20">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout
            </button>
          </form>
        </div>
      </div>
      <!-- User Area -->

    </div>
  </div>
</header><?php /**PATH C:\PROJECT FANY\Bot-Monitoring-Pekerjaan\resources\views\layouts\navbar.blade.php ENDPATH**/ ?>