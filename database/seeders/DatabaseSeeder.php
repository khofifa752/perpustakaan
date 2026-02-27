<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'petugas',
        ]);
        
          DB::table('categories')->insert([
            'name' => 'fiksi',
        ]);
        DB::table('categories')->insert([
            'name' => 'non-fiksi',
        ]);

         DB::table('books')->insert([
            'title' =>'judul buku',
            'code' => 'AF1243',
            'author' => 'jeshe',
            'publisher' => 'gramed',
            'description' => 'ini deskripsi buku...',
            'stock' => 5,
            'category_id' => 1,
        ]);

         DB::table('books')->insert([
            'title' =>'judul buku',
            'code' => 'AF1243',
            'author' => 'jeshe',
            'publisher' => 'gramed',
            'description' => 'ini deskripsi buku...',
            'stock' => 5,
            'category_id' => 2,
        ]);

         DB::table('books')->insert([
            'title' =>'Judul buku',
            'code' => 'AF1243',
            'author' => 'jeshe',
            'publisher' => 'gramed',
            'description' => 'ini deskripsi buku...',
            'stock' => 5,
            'category_id' => 1,
        ]);

        
    }
}
