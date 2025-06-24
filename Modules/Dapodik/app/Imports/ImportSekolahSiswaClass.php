<?php

namespace Modules\Dapodik\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Dapodik\Models\DapodikGuruModel;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;
use DateTime;
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSiswaModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahSiswaClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */


    private $rows = 0;
    private $npsn;

    public function __construct($npsn)
    {
        $this->npsn = $npsn;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $nama_lengkap = (isset($row['nama']) && $row['nama'] <> '-') ? $row['nama'] : NULL;
            $nisn = (isset($row['nisn']) && $row['nisn'] <> '-') ? $row['nisn'] : NULL;
            $nik = (isset($row['nik']) && $row['nik'] <> '-') ? $row['nik'] : NULL;
            $tmp_lahir = (isset($row['tmp_lahir']) && $row['tmp_lahir'] <> '-') ? $row['tmp_lahir'] : NULL;
            $tgl_lahir = (isset($row['tgl_lahir']) && $row['tgl_lahir'] <> '-') ? Date::excelToDateTimeObject($row['tgl_lahir'])->format('Y-m-d') : NULL;
            $nama_ibu = (isset($row['nama_ibu']) && $row['nama_ibu'] <> '-') ? $row['nama_ibu'] : NULL;
            $jk = (isset($row['jk']) && $row['jk'] <> '-') ? $row['jk'] : NULL;
            $tingkat = (isset($row['tingkat']) && $row['tingkat'] <> '-') ? $row['tingkat'] : NULL;
            $created_by = \Auth()->user()->id;

            if($nama_lengkap != NULL){
                $save = DapodikSiswaModel::create([
                    'nama_lengkap' => $nama_lengkap,
                    'nisn' => $nisn,
                    'nik' => $nik,
                    'tmp_lahir' => $tmp_lahir,
                    'tgl_lahir' => $tgl_lahir,
                    'nama_ibu' => $nama_ibu,
                    'jk' => $jk,
                    'tingkat' => $tingkat,
                    'npsn' => $this->npsn,
                    'kabupaten_id' => config('app.kab_id'),
                    'provinsi_id' => config('app.prov_id'),
                    'created_by' => $created_by
                ]);
                ++$this->rows;
            }
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
