<?php

namespace App\Imports;

use App\JsaImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JsaTempImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JsaImport([
            'langkah_pekerjaan' => $row['langkah_pekerjaan'],
            'potensi_bahaya_resiko' => $row['potensi_bahaya_dan_resiko'],
            'tindakan_pengendalian' => $row['tindakan_pengendalian'],
            'apd' => $row['apd'],
            'perlengkapan' => $row['perlengkapan_keselamatan_dan_darurat'],
            'users_id' => Auth::id()
        ]);
    }
}
