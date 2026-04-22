<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class AnalyticsExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct(array $data, array $headings = [])
    {
        $this->data = collect($data);
        $this->headings = $headings;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
