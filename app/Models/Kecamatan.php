<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kecamatan extends Model
{

    use HasFactory;
    protected $table = 'tb_kecamatan';

    protected $primaryKey = 'id_kecamatan';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_kecamatan',
        'geojson',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'geojson' => 'array',
    ];

    public function clusters()
    {
        return $this->hasMany(Cluster::class, 'id_kecamatan', 'id_cluster');
    }
}
