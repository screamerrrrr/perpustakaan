<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
// PENTING: Walaupun tidak dipanggil langsung, ini memastikan namespace untuk Storage sudah benar
use Illuminate\Support\Facades\Storage; 

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }
// store untuk input 
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' 
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            unset($validatedData['image']);
            $imagePath = $request->file('image')->store('books', 'public');
        } else {
            
            $imagePath = null;
        } 
        $validatedData['image'] = $imagePath;       
        Book::create($validatedData);
        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }
    // klik edit
    public function edit (Book $book){
        return view('books.edit', compact('book'));
    }
    // update
    public function update (Request $request, Book $book){
         // 1. Validasi Input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' 
        ]);

        $imagePath = $book->image;
        if ($request->hasFile('image')) {
            unset($validatedData['image']);
            $imagePath = $request->file('image')->store('books', 'public');
        }
        $validatedData['image'] = $imagePath;       
        $book->update($validatedData);
        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }
    public function destroy (Book $book){
        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();
        return redirect()->route('admin.books.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}
