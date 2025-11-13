@extends('layouts.app')

@section('header')
    Tambah User  Baru
@endsection

@section('content')

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8 dark:bg-gray-800">
        <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.user.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                <i class="fas fa-arrow-circle-left"></i>
            </a>
            Formulir Pengguna (User) Baru
        </h1>

        <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Input Nama User  (Wajib) --}}
                <div>
                    <label for="Name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama  <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('title') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
<br>
                {{-- Input Email (Wajib) --}}
                <div>
                    <label for="Email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('author') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
<br>
                {{-- Input passowrd (wajib) --}}
                <div>
                    <label for="Password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password </label>
                    <input type="text" name="password" id="password" value="{{ old('password') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white p-2 @error('publisher') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            {{-- Tombol Submit --}}
            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-150 ease-in-out flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan User 
                </button>
            </div>
        </form>
    </div>
@endsection
