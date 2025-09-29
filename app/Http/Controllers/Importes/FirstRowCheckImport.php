<?php

namespace App\Http\Controllers\Importes;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;

class FirstRowCheckImport implements ToCollection, WithLimit
{
    public array $headers = [];

    public function collection(Collection $collection)
    {
        $firstRow = $collection->first();
        $this->headers = $firstRow->toArray();
    }

    public function limit(): int
    {
        return 1;
    }
}
