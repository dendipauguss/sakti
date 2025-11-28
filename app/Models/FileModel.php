<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileModel extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = [
        'filename',
        'original_name'
    ];

    public function klasifikasi()
    {
        return $this->hasMany(KlasifikasiData::class, 'file_id');
    }
}
