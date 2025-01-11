<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    protected $table = 'tahun';
    protected $primaryKey = 'id_tahun';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'tahun',
    ];
    protected $hidden = [];
    public function aki()
    {
        return $this->hasMany(AKI::class, 'id_tahun', 'id_tahun');
    }
    public function akb()
    {
        return $this->hasMany(AKB::class, 'id_tahun', 'id_tahun');
    }
}