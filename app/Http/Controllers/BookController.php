<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $booksQuery = Book::with(['categories', 'reviews', 'collections'])
            ->withAvg('reviews', 'rating');

        if ($request->filled('searchKeyword')) {
            $keyword = $request->searchKeyword;
            $booksQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('author', 'like', "%{$keyword}%");
            });
        }

            if ($request->filled('categories')) {
            foreach ($request->categories as $catId) {
                $booksQuery->whereHas('categories', function($q) use ($catId) {
                    $q->where('categories.id', $catId);
                });
            }
        }

        return view('pages.books', [
            'books'      => $booksQuery->get(),
            'categories' => Category::all(),
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['reviews.user', 'categories'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        $canBorrow = true;

        if (auth()->check()) {
            $canBorrow = !Booking::userHasActiveLoan(auth()->id());
        } else {
            $canBorrow = false;
        }

        return view('pages.booksDetail', [
            'book'      => $book,
            'canBorrow' => $canBorrow,
        ]);
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}