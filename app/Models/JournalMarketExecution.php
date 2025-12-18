<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalMarketExecution extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_upload_id',
        'no_akun',
        'no_tiket',
        'tanggal',
        'request_time',
        'confirm_time',
        'delay_microseconds',
        'delay_seconds',
        'delay_formatted',
        'request_raw',
        'confirm_raw',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'delay_seconds' => 'float',
    ];
}
