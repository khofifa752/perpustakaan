<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{

    public function toggle(Request $request, $bookId)
    {
        $userId = auth()->id();

        $existing = Collection::where('user_id', $userId)
                              ->where('book_id', $bookId)
                              ->first();

        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            Collection::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            $saved = true;
        }

        return response()->json([
            'saved' => $saved,
            'count' => Collection::where('user_id', $userId)->count(),
        ]);
    }

    // Halaman daftar koleksi user
    public function index()
    {
        $collections = auth()->user()
                             ->collections()
                             ->with('book.reviews')
                             ->latest()
                             ->get();

        return view('pages.collections', compact('collections'));
    }
}