<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBooksController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return view('admin.pages.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.pages.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'publisher'    => 'required|string|max:255',
            'description'  => 'required|string',
            'stock'        => 'required|string',       
            'category_id'  => 'required|string',      
            'tahun_terbit' => 'nullable|digits:4',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'code'         => 'nullable|string',
        ]);

        // Upload cover kalau ada file
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.pages.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'publisher'    => 'required|string|max:255',
            'description'  => 'required|string',
            'stock'        => 'required|string',
            'category_id'  => 'required|string',
            'tahun_terbit' => 'nullable|digits:4',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'code'         => 'nullable|string',
        ]);

        
        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
          
            unset($data['cover']);
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diupdate.');
    }

    public function destroy(Book $book)
    {
       
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
