<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalCreditFacility extends Model
{
    use HasFactory;

    protected $table = 'journal_credit_facilities';

    protected $guarded = ['id'];
}
