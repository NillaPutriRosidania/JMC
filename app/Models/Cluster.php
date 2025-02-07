<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;
    protected $table = 'cluster';
    protected $primaryKey = 'id_cluster';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_cluster', 'nama_cluster'];
    public $timestamps = false;
}