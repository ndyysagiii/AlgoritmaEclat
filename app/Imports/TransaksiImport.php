<?php

namespace App\Imports;

use App\Models\Transaksi;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaksiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new Transaksi([
            'tanggal' => Date::excelToDateTimeObject($row['tanggal'])->format('Y-m-d'),
            'obat' => $row['obat'],
        ]);
    }
}
