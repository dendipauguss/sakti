<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalIPPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'journal_ip_perusahaan';

    protected $guarded = ['id'];
}
