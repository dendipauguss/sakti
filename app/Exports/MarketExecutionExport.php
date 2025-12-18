<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\JournalMarketExecution;

class MarketExecutionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return JournalMarketExecution::select(
            'no_akun',
            'no_tiket',
            'tanggal',
            'request_time',
            'confirm_time',
            'delay_formatted',
            'delay_seconds'
        )->get();
    }

    public function headings(): array
    {
        return [
            'No Akun',
            'No Tiket',
            'Tanggal',
            'Request Time',
            'Confirm Time',
            'Delay (HH:MM:SS.mmm)',
            'Delay (detik)'
        ];
    }
}
