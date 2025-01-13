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
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }

}