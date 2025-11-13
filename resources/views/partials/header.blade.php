<header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center dark:bg-gray-700">
    <h1 class="text-lg font-semibold text-gray-800 dark:text-white">
        {{ $header ?? 'Dashboard' }}
    </h1>
    <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggle -->
        <button id="theme-toggle" onclick="toggleDarkMode()" class="text-gray-700 dark:text-gray-300">
            <i id="theme-toggle-dark-icon" class="fas fa-moon hidden dark:block"></i>
            <i id="theme-toggle-light-icon" class="fas fa-sun dark:hidden"></i>
        </button>
        @if (Auth::user()->role === 'admin')
        <span class="text-gray-700 dark:text-white">Halo, {{ Auth::user()->name ?? 'User' }} 👋</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm flex items-center dark:text-red-400 dark:hover:text-red-300">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
        @else
        <span class="text-gray-700 dark:text-white">Halo, {{ Auth::user()->name ?? 'User' }} 👋</span>
        <form method="POST" action="{{ route('peminjam.logout') }}">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700 text-sm flex items-center dark:text-red-400 dark:hover:text-red-300">
                <i class="fas fa-sign-out-alt mr-1"></i> Logout
            </button>
        </form>
        @endif
    </div>
</header>

<script>
    // Update icons based on theme
    if (document.documentElement.classList.contains('dark')) {
        document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
        document.getElementById('theme-toggle-light-icon').classList.add('hidden');
    } else {
        document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
        document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
    }
</script>