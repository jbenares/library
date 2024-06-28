<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'book_details'; 
    protected $fillable = [
        'book_name',
        'author',
        'book_cover'
    ];

}
