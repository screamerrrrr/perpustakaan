<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User; // Asumsi Model User ada
use Carbon\Carbon; // Digunakan untuk dueDate
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource (Active Borrowings).
     */
    public function index()
    {
        // Ambil semua peminjaman yang BELUM dikembalikan (returned_at IS NULL)
        $borrowings = Borrowing::with(['book', 'user'])
                            ->whereNull('returned_at')
                            ->orderBy('due_date', 'asc')
                            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource (New Borrowing).
     */
    public function create()
    {
        // Ambil buku yang stoknya > 0
        $availableBooks = Book::where('stock', '>', 0)->pluck('title', 'id');
        
        // Ambil semua user (untuk di-select box)
        $users = User::all();

        return view('borrowings.create', compact('availableBooks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        // Cek stok buku sebelum menyimpan
        $book = Book::find($validatedData['book_id']);
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku ini tidak tersedia untuk dipinjam.');
        }

        // Mulai transaksi database
        DB::transaction(function () use ($validatedData, $book) {
            // 1. Buat record peminjaman
            Borrowing::create([
                'book_id' => $validatedData['book_id'],
                'user_id' => $validatedData['user_id'],
                'borrowed_at' => Carbon::now(),
                'due_date' => $validatedData['due_date'],
                'status' => 'borrowed',
            ]);

            // 2. Kurangi stok buku
            $book->decrement('stock');
        });

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Handle the return of a book and update stock.
     */
    public function returnBook(Borrowing $borrowing)
    {
        // Pastikan buku belum dikembalikan
        if ($borrowing->returned_at !== null) {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        // Mulai transaksi database
        DB::transaction(function () use ($borrowing) {
            // 1. Update record peminjaman
            $borrowing->update([
                'returned_at' => Carbon::now(),
                'status' => 'returned',
            ]);

            // 2. Tambahkan kembali stok buku
            $borrowing->book->increment('stock');
        });

        return redirect()->route('borrowings.index')->with('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
    }
}
