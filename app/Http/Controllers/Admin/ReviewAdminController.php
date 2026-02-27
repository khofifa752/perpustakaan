<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $reviews = Review::with(['user','book'])
            ->when($q, function ($query) use ($q) {
                $query->whereHas('user', fn($u) => $u->where('name','like',"%$q%")->orWhere('email','like',"%$q%"))
                      ->orWhereHas('book', fn($b) => $b->where('title','like',"%$q%"))
                      ->orWhere('comment','like',"%$q%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews','q'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}