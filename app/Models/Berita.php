<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $fillable = ['judul', 'isi', 'gambar', 'kategori', 'kata_kunci', 'diterbitkan'];
}