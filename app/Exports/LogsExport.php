<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogsExport implements FromCollection, WithHeadings
{
    use Exportable;
    public $data;
    public function __construct($logs)
    {
        $this->data = $logs;
    }

    public function headings(): array
    {
        return [
            'changer', 'change_holder', 'product', 'quantity', 'operation', 'time',
        ];
    }
    public function collection()
    {
        return collect($this->data);
    }
}
