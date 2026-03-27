<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $booksQuery = Book::with('category')
        ->withAvg('reviews', 'rating');

    // SEARCH
    if ($request->filled('searchKeyword')) {
        $keyword = $request->searchKeyword;

        $booksQuery->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
              ->orWhere('author', 'like', "%{$keyword}%");
        });
    }

    
    if ($request->filled('categories')) {
        $booksQuery->whereIn('category_id', $request->categories);
    }

    return view('pages.books', [
        'books' => $booksQuery->get(),
        'categories' => Category::all(),
    ]);
}
    /**
     * Show the form for creating a new resource.
     */ 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['reviews.user','category'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        $canBorrow = true;

        if (auth()->check()) {
            $canBorrow = !\App\Models\Booking::where('user_id', auth()->id())
                ->whereIn('status', ['Diajukan','Disetujui'])
                ->exists();
        } else {
            $canBorrow = false; 
        }

        return view('pages.booksDetail', [
            'book' => $book,
            'canBorrow' => $canBorrow,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
