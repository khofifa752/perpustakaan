<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
public const ACTIVE_STATUSES = ['Diajukan', 'Disetujui', 'Dipinjam','menunggu pengembalian']; 

public static function userHasActiveLoan(int $userId): bool
{
    return self::where('user_id', $userId)
        ->whereIn('status', self::ACTIVE_STATUSES)
        ->exists();
}

    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'expired_at' => 'date',
        'returned_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    
    public function review()
    {
        return $this->hasOne(Review::class);
    }

}
