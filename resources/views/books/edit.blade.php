@extends('layouts.app')

@section('header')
    Dashboard | Edit Buku
@endsection

@section('content')

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800 max-w-2xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">Edit Data Buku: {{ $book->title }}</h2>

        {{-- Form Edit, perhatikan method POST, @method('PUT'), dan enctype untuk file upload --}}
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Digunakan untuk menandakan permintaan UPDATE/PATCH --}}

            {{-- Judul Buku --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Buku <span class="text-red-500">*</span></label>
                {{-- Menggunakan old() untuk menjaga nilai saat validasi gagal, atau nilai dari $book --}}
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2" 
                       value="{{ old('title', $book->title) }}" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penulis --}}
            <div class="mb-4">
                <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penulis <span class="text-red-500">*</span></label>
                <input type="text" name="author" id="author" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2" 
                       value="{{ old('author', $book->author) }}" required>
                @error('author')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penerbit --}}
            <div class="mb-4">
                <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penerbit</label>
                <input type="text" name="publisher" id="publisher" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2" 
                       value="{{ old('publisher', $book->publisher) }}">
                @error('publisher')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Tahun Terbit --}}
                <div class="mb-4">
                    <label for="publication_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Terbit</label>
                    <input type="number" name="publication_year" id="publication_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2" 
                           value="{{ old('publication_year', $book->publication_year) }}" min="1900" max="{{ date('Y') }}">
                    @error('publication_year')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2" 
                           value="{{ old('stock', $book->stock) }}" required min="0">
                    @error('stock')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Gambar (Cover) --}}
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cover Buku (Kosongkan jika tidak ingin mengubah)</label>
                
                {{-- Tampilkan Cover Lama --}}
                @if ($book->image)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Cover saat ini:</p>
                        <img src="{{ asset('storage/' . $book->image) }}" alt="Cover {{ $book->title }}" 
                            class="h-24 w-auto object-cover rounded-md shadow-md mt-1"
                            onerror="this.onerror=null; this.src='https://placehold.co/96x96/ccc/333?text=Gambar+Rusak';">
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Tidak ada cover terpasang.</p>
                @endif
                
                {{-- Input file baru --}}
                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimum 2MB. Format: JPG, JPEG, PNG. Mengganti file akan menghapus cover lama.</p>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.books.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-150">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition duration-150">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@endsection
