<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection; 
class DashboardController extends Controller
{
   public function index()
    {
        // 1. Hitung Statistik Real-time
        $totalBooks = Book::count();
        $borrowedBooks = Borrowing::whereNull('returned_at')->count();
        
        // Hitung buku yang terlambat (due_date sudah lewat dan belum dikembalikan)
        $overdueBooks = Borrowing::whereNull('returned_at')
                                 ->where('due_date', '<', Carbon::today())
                                 ->count();

        // 2. Ambil Aktivitas Terbaru
        $recentActivities = $this->getRecentActivities();

        return view('dashboard', compact(
            'totalBooks',
            'borrowedBooks',
            'overdueBooks',
            'recentActivities'
        ));
    }
    private function getRecentActivities()
    {
        // Ambil 5 Buku Terbaru (Aktivitas Penambahan)
        $newBooks = Book::orderBy('created_at', 'desc')->take(5)->get();

        // Ambil 5 Peminjaman/Pengembalian Terbaru
        $transactions = Borrowing::with(['book', 'user'])
                                ->orderBy('updated_at', 'desc')
                                ->take(5)
                                ->get();
        
        // Gabungkan kedua koleksi
        // Collection::merge() mempertahankan tipe data
        $activities = $newBooks->merge($transactions);
        
        // Urutkan kembali koleksi gabungan berdasarkan created_at atau updated_at
        // Menggunakan sortByDesc untuk mengurutkan dari yang terbaru
        $activities = $activities->sortByDesc(function ($item) {
            // Gunakan updated_at untuk Borrowing, karena itu mencakup pinjam (created) dan kembali (updated)
            return $item->updated_at ?? $item->created_at;
        });

        // Batasi hasilnya kembali menjadi 5 atau 10, tergantung kebutuhan tampilan
        return $activities->take(10);
    }
}
