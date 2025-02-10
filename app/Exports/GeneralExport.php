<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GeneralExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct($data, $headings = [])
    {
        $this->data = $data;
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