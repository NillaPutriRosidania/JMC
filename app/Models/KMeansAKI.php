<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KMeansAKI extends Model
{
    use HasFactory;

    protected $table = 'kmeans_aki';

    protected $fillable = [
        'id_kecamatan',
        'grand_total_aki',
        'id_cluster',
        'id_cluster_3',
        'id_cluster_4',
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
