@extends('layouts.app')

@section('header')
    Dashboard | Daftar Buku
@endsection

@section('content')

    <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">

        {{-- Pesan Sukses/Error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        

        {{-- Tabel Daftar Buku --}}
        <div class="overflow-x-auto border border-gray-200 rounded-lg dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">No.</th>
                        {{-- KOLOM COVER --}}
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">Cover</th>
                        {{-- END KOLOM COVER --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-4/12">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-2/12">Penulis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-2/12">Penerbit</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/12">Stok</th>
                    </tr>
                </thead>
                {{-- ID untuk target JavaScript --}}
                <tbody id="bookTableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                    @forelse ($books as $index => $book)
                    {{-- Class untuk target JavaScript --}}
                    <tr class="book-row hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-100">
                        {{-- Menggunakan index sederhana (akan ditimpa oleh JS) --}}
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $index + 1 }}</td>
                        
                        {{-- TAMPILKAN GAMBAR DARI STORAGE --}}
                        <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Cover {{ $book->title }}" 
                                    class="h-16 w-12 object-cover rounded-md shadow-md mx-auto"
                                    onerror="this.onerror=null; this.src='https://placehold.co/48x64/ccc/333?text=No+Img';">
                            @else
                                <span class="text-xs text-gray-400 block text-center">N/A</span>
                            @endif
                        </td>
                        {{-- END TAMPILKAN GAMBAR --}}

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $book->title }}
                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                (Terbit: {{ $book->publication_year ?? '-' }})
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $book->author }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $book->publisher ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $book->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $book->stock }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- Colspan = 7 --}}
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-exclamation-circle mr-2"></i> Belum ada data buku yang tersedia. Silakan tambahkan buku baru.
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
            const tableBody = document.getElementById('bookTableBody');
            const rows = document.querySelectorAll('.book-row');
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
                    pageInfo.textContent = 'Menampilkan 0 dari 0 buku';
                } else {
                    const displayEnd = Math.min(end, totalRows);
                    pageInfo.textContent = `Menampilkan ${start + 1} sampai ${displayEnd} dari ${totalRows} buku`;
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
