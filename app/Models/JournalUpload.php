<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalUpload extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];

    public function marketExecutions()
    {
        return $this->hasMany(JournalMarketExecution::class);
    }

    public function wrongPrices()
    {
        return $this->hasMany(JournalWrongPrice::class);
    }

    public function creditFacilities()
    {
        return $this->hasMany(JournalCreditFacility::class);
    }
}
