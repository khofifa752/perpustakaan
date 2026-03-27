<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminBooksController extends Controller
{
    public function index()
    {
        $books = Book::with('categories')->latest()->get();
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
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
            'tahun_terbit' => 'nullable|digits:4',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'code'         => 'nullable|string',
        ]);

        // ✅ FIX ERROR: isi category_id dari kategori pertama
        $data['category_id'] = $request->categories[0];

        // upload cover
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // simpan buku
        $book = Book::create($data);

        // simpan kategori banyak
        $book->categories()->attach($request->categories);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $book->load('categories');

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
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
            'tahun_terbit' => 'nullable|digits:4',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'code'         => 'nullable|string',
        ]);

        // ✅ FIX ERROR: update category_id juga
        $data['category_id'] = $request->categories[0];

        // upload cover baru
        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        } else {
            unset($data['cover']);
        }

        // update buku
        $book->update($data);

        // update kategori banyak
        $book->categories()->sync($request->categories);

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

    public function laporanPdf(Request $request)
    {
        $q = $request->query('q');

        $books = Book::with('categories')
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('author', 'like', "%{$q}%")
                    ->orWhere('publisher', 'like', "%{$q}%")
                    ->orWhereHas('categories', function ($c) use ($q) {
                        $c->where('name', 'like', "%{$q}%");
                    });
            })
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.pages.books.laporan-pdf', compact('books', 'q'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-buku.pdf');
    }
}