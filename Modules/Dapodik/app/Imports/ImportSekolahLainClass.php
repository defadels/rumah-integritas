<?php

namespace Modules\Dapodik\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DateTime;
use Modules\Dapodik\Models\DapodikSekolahAdministrasiModel;
use Modules\Dapodik\Models\DapodikSekolahLainModel;
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahRuangKelasModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahLainClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */


    private $rows = 0;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $nama_sekolah = (isset($row['nama_sekolah']) && $row['nama_sekolah'] <> 'null') ? $row['nama_sekolah'] : NULL;
            $npsn = (isset($row['npsn']) && $row['npsn'] <> 'null') ? $row['npsn'] : NULL;
            $meja_siswa = (isset($row['meja_siswa']) && is_numeric($row['meja_siswa'])) ? $row['meja_siswa'] : 0;
            $kursi_siswa = (isset($row['kursi_siswa']) && is_numeric($row['kursi_siswa'])) ? $row['kursi_siswa'] : 0;
            $papan_tulis = (isset($row['papan_tulis']) && is_numeric($row['papan_tulis'])) ? $row['papan_tulis'] : 0;
            $komputer = (isset($row['komputer']) && is_numeric($row['komputer'])) ? $row['komputer'] : 0;
            $guru = (isset($row['guru']) && is_numeric($row['guru'])) ? $row['guru'] : 0;
            $tendik = (isset($row['tendik']) && is_numeric($row['tendik'])) ? $row['tendik'] : 0;
            $profile = (isset($row['profile']) && $row['profile'] <> 'null') ? $row['profile'] : NULL;

            $created_by = \Auth()->user()->id;

            $save = DapodikSekolahLainModel::create([
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'meja_siswa' => $meja_siswa,
                'kursi_siswa' => $kursi_siswa,
                'papan_tulis' => $papan_tulis,
                'komputer' => $komputer,
                'guru' => $guru,
                'tendik' => $tendik,
                'profile' => $profile,
                'created_by' => $created_by
            ]);
            if($save){
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
