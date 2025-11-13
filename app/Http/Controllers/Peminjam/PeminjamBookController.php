<?php

namespace App\Http\Controllers\Peminjam;
use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $books = Book::all();
        return view('peminjam/books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    
}
