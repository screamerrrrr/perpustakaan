@extends('layouts.app')

@section('header')
    Buat Peminjaman Baru
@endsection

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-lg dark:bg-gray-800 dark:text-white">
        <form action="{{ route('admin.borrowings.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Pilih Buku -->
                <div class="space-y-2">
                    <label for="book_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buku yang Dipinjam</label>
                    <select name="book_id" id="book_id" class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">-- Pilih Buku (Stok Tersedia) --</option>
                        {{-- Data $availableBooks didapat dari BorrowingController::create() --}}
                        @foreach($availableBooks as $id => $title)
                            <option value="{{ $id }}" {{ old('book_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pilih Peminjam (User) -->
                <div class="space-y-2">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Peminjam</label>
                    <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">-- Pilih Peminjam --</option>
                        {{-- Data $users didapat dari BorrowingController::create() --}}
                        @foreach($users as $user)
                            <!-- Asumsi Model User memiliki kolom 'name' -->
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name ?? 'User ID: ' . $user->id }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Jatuh Tempo -->
                <div class="space-y-2">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Jatuh Tempo</label>
                    <input type="date" name="due_date" id="due_date" class="w-full border-gray-300 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="{{ old('due_date', \Carbon\Carbon::now()->addDays(7)->format('Y-m-d')) }}" required>
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-handshake mr-2"></i> Konfirmasi Peminjaman
                </button>
            </div>
        </form>
    </div>
@endsection
