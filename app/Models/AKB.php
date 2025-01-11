<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AKB extends Model
{
    use HasFactory;
    protected $table = 'data_akb';

    protected $primaryKey = 'id_data_akb';
    public $incrementing = true;
    protected $fillable = [
        'id_puskesmas',
        'id_kecamatan',
        'id_tahun',
        'akb',
    ];

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas');
    }
    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun', 'id_tahun');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
}