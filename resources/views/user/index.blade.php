@extends('layouts.app')

@section('header')
    Dashboard | Daftar User
@endsection

@section('content')

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">

        {{-- Pesan Sukses/Error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @elseif (session('error'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tombol Tambah User --}}
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Manajemen User</h2>
            <a href="{{ route('admin.user.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center shadow-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i> Tambah User Baru
            </a>
        </div>

        {{-- Tabel Daftar User --}}
        <div class="overflow-x-auto border border-gray-200 rounded-lg dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">No.</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-4/12">Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-4/12">Aksi</th>
                    </tr>
                </thead>
                {{-- PERUBAHAN: Mengganti ID 'bookTableBody' menjadi 'userTableBody' --}}
                <tbody id="userTableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                    @forelse ($users as $index => $user)
                    {{-- PERUBAHAN: Mengganti Class 'book-row' menjadi 'user-row' --}}
                    <tr class="user-row hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-100">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $user->email}}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition duration-150 mr-3">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            
                            {{-- Form Hapus --}}
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus User ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition duration-150">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-exclamation-circle mr-2"></i> Belum ada data User yang tersedia. Silakan tambahkan User baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION CONTROLS DIBUAT DENGAN JS --}}
        <div id="paginationControls" class="flex justify-between items-center mt-6">
            <span id="pageInfo" class="text-sm text-gray-700 dark:text-gray-400"></span>
            <div id="paginationLinks" class="flex space-x-2">
                {{-- Link pagination akan dimasukkan oleh JavaScript --}}
            </div>
        </div>
        
    </div>

    {{-- Script JavaScript untuk Pagination --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // PERUBAHAN: Mengganti ID 'bookTableBody' menjadi 'userTableBody'
            const tableBody = document.getElementById('userTableBody');
            // PERUBAHAN: Mengganti Selector '.book-row' menjadi '.user-row'
            const rows = document.querySelectorAll('.user-row');
            const paginationLinks = document.getElementById('paginationLinks');
            const pageInfo = document.getElementById('pageInfo');
            
            // Konfigurasi Pagination
            const rowsPerPage = 5; // Tampilkan 5 baris per halaman
            let currentPage = 1;
            const totalRows = rows.length;
            const pageCount = Math.ceil(totalRows / rowsPerPage);

            /**
             * Fungsi untuk menampilkan baris yang sesuai dengan halaman saat ini
             * @param {number} page
             */
            function paginateTable(page) {
                currentPage = page;
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    if (index >= start && index < end) {
                        row.style.display = 'table-row'; // Tampilkan baris
                    } else {
                        row.style.display = 'none'; // Sembunyikan baris
                    }
                    
                    // Update nomor urut (penting untuk client-side pagination)
                    const indexCell = row.querySelector('td:first-child');
                    if (indexCell) {
                         // Nomor urut yang disesuaikan
                        indexCell.textContent = index + 1; 
                    }
                });

                updatePaginationControls();
                updatePageInfo(start, end);
            }

            /**
             * Fungsi untuk membuat dan memperbarui tombol-tombol pagination
             */
            function updatePaginationControls() {
                paginationLinks.innerHTML = '';

                // Tombol Sebelumnya
                const prevButton = createPaginationButton('Prev', currentPage - 1, currentPage > 1);
                paginationLinks.appendChild(prevButton);

                // Tombol Angka Halaman
                for (let i = 1; i <= pageCount; i++) {
                    const button = createPaginationButton(i, i, true);
                    if (i === currentPage) {
                        // Styling untuk halaman aktif
                        button.classList.add('bg-indigo-600', 'text-white', 'hover:bg-indigo-700');
                        button.classList.remove('bg-gray-200', 'text-gray-700', 'dark:bg-gray-700', 'dark:text-gray-300');
                    }
                    paginationLinks.appendChild(button);
                }

                // Tombol Berikutnya
                const nextButton = createPaginationButton('Next', currentPage + 1, currentPage < pageCount);
                paginationLinks.appendChild(nextButton);
            }
            
            /**
             * Membuat elemen tombol pagination
             */
            function createPaginationButton(text, pageNum, isEnabled) {
                const button = document.createElement('button');
                button.textContent = text;
                button.className = `px-3 py-1 rounded-lg text-sm font-medium transition duration-150 ease-in-out ${
                    isEnabled 
                        ? 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600'
                        : 'bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-800 dark:text-gray-500'
                }`;
                
                // Hanya tambahkan event listener jika tombol diaktifkan dan bukan angka halaman saat ini
                if (isEnabled && pageNum !== currentPage) {
                    button.addEventListener('click', () => paginateTable(pageNum));
                }

                return button;
            }

            /**
             * Menampilkan informasi baris
             */
            function updatePageInfo(start, end) {
                if (totalRows === 0) {
                    pageInfo.textContent = 'Menampilkan 0 dari 0 User';
                } else {
                    const displayEnd = Math.min(end, totalRows);
                    pageInfo.textContent = `Menampilkan ${start + 1} sampai ${displayEnd} dari ${totalRows} User`;
                }
            }

            // Inisialisasi: Hanya jalankan jika ada baris data
            if (totalRows > 0) {
                paginateTable(1);
            } else {
                // Jika tidak ada data, sembunyikan kontrol pagination
                document.getElementById('paginationControls').style.display = 'none';
            }
        });
    </script>
@endsection