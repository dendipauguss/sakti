<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KlasifikasiData extends Model
{
    use HasFactory;

    protected $table = 'klasifikasi_data';

    protected $fillable = [
        'file_id',
        'content',
        'category'
    ];

    public function file()
    {
        return $this->belongsTo(FileModel::class, 'file_id');
    }
}
