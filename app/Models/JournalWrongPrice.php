<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalWrongPrice extends Model
{
    use HasFactory;

    protected $table = 'journal_wrong_prices';

    protected $guarded = ['id'];
}
