<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
    use HasFactory;

    protected $table = 'puskesmas'; // Sesuaikan dengan nama tabel di database

    protected $primaryKey = 'id_puskesmas'; // Sesuaikan dengan primary key tabel

    protected $fillable = [
        'nama_puskesmas',
        'id_kecamatan',
        'alamat_puskesmas',
        'lat',
        'long',
    ];

    /**
     * Relasi dengan model Kecamatan.
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }
    public function aki()
    {
        return $this->hasMany(AKI::class, 'id_puskesmas');
    }
}