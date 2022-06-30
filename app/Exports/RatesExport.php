<?php

namespace App\Exports;

use App\Models\Rate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RatesExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Rate::all();
    }

    public function headings(): array
    {
        \Log::info($this->collection()->first()->keys()->toArray());
    }
}
