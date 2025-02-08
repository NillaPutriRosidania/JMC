<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KMeansAKB extends Model
{
    use HasFactory;

    protected $table = 'kmeans_akb';
    protected $primaryKey = 'id_kmeans_akb';
    protected $fillable = [
        'id_kecamatan',
        'grand_total_akb',
        'id_cluster',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class, 'id_puskesmas');
    }
    public function cluster()
    {
        return $this->belongsTo(Cluster::class, 'id_cluster', 'id_cluster');
    }
}
