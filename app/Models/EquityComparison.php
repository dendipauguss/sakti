<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquityComparison extends Model
{
    use HasFactory;

    protected $table = 'equity_comparisons';

    protected $guarded = ['id'];

    public function equityReport()
    {
        return $this->belongsTo(EquityReport::class);
    }
}
