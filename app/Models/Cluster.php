<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'cluster';

    // Primary key
    protected $primaryKey = 'id_cluster';

    // Primary key bukan auto-increment
    public $incrementing = false;

    // Tipe data primary key
    protected $keyType = 'string';

    // Field yang dapat diisi
    protected $fillable = ['id_cluster', 'nama_cluster'];

    // Menonaktifkan timestamps jika tidak digunakan
    public $timestamps = false;
}
