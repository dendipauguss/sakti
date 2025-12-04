<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KlasifikasiExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // return collection yang berisi array untuk tiap baris
        return $this->data->map(function ($row) {
            return [
                'id' => $row->id,
                'file_id' => $row->file_id,
                'content' => $row->content,
                'category' => $row->category,
                'created_at' => $row->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'File ID', 'Content', 'Category', 'Created At'];
    }
}
