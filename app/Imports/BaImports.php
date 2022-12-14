<?php

namespace App\Imports;

use App\BaImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class BaImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new BaImport([
            'kategori' => $row[0],
            'nomor_kontrak' => $row[1],
            'nomor_ba' => $row[2],
            'tanggal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row[3]))->format('Y-m-d'),
            'users_id' => Auth::id()
        ]);
    }
}
