@extends('layouts.app')

@section('header')
    Tambah Buku Baru
@endsection

@section('content')

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8 dark:bg-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                <i class="fas fa-arrow-circle-left"></i>
            </a>
            Formulir Buku Baru
        </h1>

        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Judul Buku (Wajib) --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penulis (Wajib) --}}
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="author" id="author" value="{{ old('author') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('author') border-red-500 @enderror">
                    @error('author')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit (Wajib) --}}
                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penerbit </label>
                    <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('publisher') border-red-500 @enderror">
                    @error('publisher')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tahun Terbit (Wajib) --}}
                <div>
                    <label for="publication_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Terbit </label>
                    <input type="number" name="publication_year" id="publication_year" value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('publication_year') border-red-500 @enderror">
                    @error('publication_year')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok (Wajib) --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('stock') border-red-500 @enderror">
                    @error('stock')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- GAMBAR BUKU (FILE UPLOAD, Opsional) --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Cover (Opsional)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-800 dark:file:text-blue-200 dark:text-gray-400">
                    @error('image')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Max 2MB. Format: JPG, JPEG, PNG.</p>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
@endsection
