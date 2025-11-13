<aside class="w-64 sidebar text-white flex flex-col">
    <div class="p-6 border-b border-blue-700">
        <h1 class="text-xl font-bold flex items-center">
            <i class="fas fa-book mr-2"></i> PerpustakaanKu
        </h1>
        <p class="text-sm mt-1 opacity-80">Manajemen Buku & Peminjaman</p>
    </div>
    <nav class="mt-6 flex-1">
         @if (Auth::user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>
           <a href="{{ route('admin.books.index') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-book mr-3"></i> Daftar Buku
        </a>
        <a href="{{ route('admin.borrowings.index') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-exchange-alt mr-3"></i> Peminjaman
        </a>
        <a href="{{ route('admin.user.index') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-exchange-alt mr-3"></i> Daftar Pengguna (User)
        </a>
        @endif
        @if (Auth::user()->role === 'user')
        <a href="{{ route('peminjam.dashboard') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
        </a>
         <a href="{{ route('peminjam.books.index') }}" class="flex items-center px-6 py-3 text-white hover:bg-blue-700 transition">
            <i class="fas fa-book mr-3"></i> Daftar Buku
        </a>
        
        @endif
        
    </nav>
    <div class="p-6 border-t border-blue-700 text-xs opacity-70">
        © 2025 PerpustakaanKu
    </div>
</aside>