<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquityReport extends Model
{
    use HasFactory;

    protected $table = 'equity_uploads';

    protected $guarded = ['id'];

    public function snapshots()
    {
        return $this->hasMany(EquitySnapshot::class);
    }

    public function comparisons()
    {
        return $this->hasMany(EquityComparison::class);
    }
}
