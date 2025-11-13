@extends('layouts.app')

@section('header')
    Dashboard
@endsection

@section('content')
    <!-- Welcome Card -->
    <div class="bg-blue-600 text-white rounded-xl p-6 mb-6 dark:bg-blue-800">
        <h2 class="text-xl font-bold">Selamat Datang di PerpustakaanKu!</h2>
        <p class="mt-1 text-blue-100">Akses informasi terbaru dan kelola buku dengan mudah.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Buku -->
        <div class="bg-white rounded-xl p-5 card flex items-center dark:bg-gray-700 dark:text-white">
            <div class="p-3 bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                <i class="fas fa-book text-blue-600 dark:text-blue-300"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-300">Total Buku</p>
                <p class="text-2xl font-bold dark:text-white">{{ $totalBooks ?? 0 }}</p>
            </div>
        </div>

        <!-- Dipinjam -->
        <div class="bg-white rounded-xl p-5 card flex items-center dark:bg-gray-700 dark:text-white">
            <div class="p-3 bg-yellow-100 rounded-full mr-4 dark:bg-yellow-900">
                <i class="fas fa-exchange-alt text-yellow-600 dark:text-yellow-300"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-300">Dipinjam</p>
                <p class="text-2xl font-bold dark:text-white">{{ $borrowedBooks ?? 0 }}</p>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="bg-white rounded-xl p-5 card flex items-center dark:bg-gray-700 dark:text-white">
            <div class="p-3 bg-red-100 rounded-full mr-4 dark:bg-red-900">
                <i class="fas fa-clock text-red-600 dark:text-red-300"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm dark:text-gray-300">Terlambat</p>
                <p class="text-2xl font-bold dark:text-white">{{ $overdueBooks ?? 0 }}</p>
            </div>
        </div>
    </div>
    <!-- Recent Activity -->
    <div class="bg-white rounded-xl p-6 card dark:bg-gray-700 dark:text-white">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Aktivitas Terbaru</h3>
        <div class="space-y-3">
            
            @forelse ($recentActivities as $activity)
                
                @if ($activity instanceof \App\Models\Book)
                    {{-- TAMPILAN JIKA AKTIVITAS ADALAH BUKU BARU --}}
                    <div class="flex items-center p-3 border border-gray-200 rounded-lg dark:border-gray-600 dark:bg-gray-800">
                        <div class="p-2 bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                            <i class="fas fa-book-medical text-blue-600 dark:text-blue-300"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium dark:text-white">Buku Baru Ditambahkan</p>
                            <p class="text-gray-600 text-sm dark:text-gray-300">
                                <span class="font-semibold">{{ $activity->title }}</span> oleh {{ $activity->author }}
                            </p>
                        </div>
                        <span class="text-gray-500 text-sm dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>

                @elseif ($activity instanceof \App\Models\Borrowing)
                    
                    @if ($activity->returned_at)
                        {{-- TAMPILAN JIKA AKTIVITAS ADALAH PENGEMBALIAN --}}
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg dark:border-gray-600 dark:bg-gray-800">
                            <div class="p-2 bg-green-100 rounded-full mr-4 dark:bg-green-900">
                                <i class="fas fa-check text-green-600 dark:text-green-300"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium dark:text-white">Buku Dikembalikan</p>
                                <p class="text-gray-600 text-sm dark:text-gray-300">
                                    <span class="font-semibold">{{ $activity->book->title ?? 'Buku Dihapus' }}</span> oleh {{ $activity->user->name ?? 'User Dihapus' }}
                                </p>
                            </div>
                            <span class="text-gray-500 text-sm dark:text-gray-400">{{ $activity->updated_at->diffForHumans() }}</span>
                        </div>
                    
                    @else
                        {{-- TAMPILAN JIKA AKTIVITAS ADALAH PEMINJAMAN BARU --}}
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg dark:border-gray-600 dark:bg-gray-800">
                            <div class="p-2 {{ $activity->status == 'overdue' ? 'bg-red-100 dark:bg-red-900' : 'bg-yellow-100 dark:bg-yellow-900' }}">
                                <i class="fas {{ $activity->status == 'overdue' ? 'fa-clock text-red-600 dark:text-red-300' : 'fa-exchange-alt text-yellow-600 dark:text-yellow-300' }}"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium dark:text-white">{{ $activity->status == 'overdue' ? 'Peminjaman Terlambat' : 'Buku Dipinjam' }}</M</p>
                                <p class="text-gray-600 text-sm dark:text-gray-300">
                                    <span class="font-semibold">{{ $activity->book->title ?? 'Buku Dihapus' }}</span> oleh {{ $activity->user->name ?? 'User Dihapus' }}
                                </p>
                            </div>
                            <span class="text-gray-500 text-sm dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    @endif

                @endif

            @empty
                <div class="p-3 text-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-exclamation-circle mr-2"></i> Belum ada aktivitas terbaru.
                </div>
            @endforelse

        </div>
    </div>
@endsection
