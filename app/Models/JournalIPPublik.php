<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalIPPublik extends Model
{
    use HasFactory;

    protected $table = 'same_ip_publik';

    protected $guarded = ['id'];
}
