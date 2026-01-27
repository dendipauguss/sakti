<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquityReport extends Model
{
    use HasFactory;

    protected $table = 'equity_report';

    protected $guarded = ['id'];
}
