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
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahRuangKelasModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahRuangKelasClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
            $ruang_kelas_baik = (isset($row['ruang_kelas_baik']) && is_numeric($row['ruang_kelas_baik'])) ? $row['ruang_kelas_baik'] : 0;
            $ruang_kelas_rusak_ringan = (isset($row['ruang_kelas_rusak_ringan']) && is_numeric($row['ruang_kelas_rusak_ringan'])) ? $row['ruang_kelas_rusak_ringan'] : 0;
            $ruang_kelas_rusak_sedang = (isset($row['ruang_kelas_rusak_sedang']) && is_numeric($row['ruang_kelas_rusak_sedang'])) ? $row['ruang_kelas_rusak_sedang'] : 0;
            $ruang_kelas_rusak_berat = (isset($row['ruang_kelas_rusak_berat']) && is_numeric($row['ruang_kelas_rusak_berat'])) ? $row['ruang_kelas_rusak_berat'] : 0;
            $ruang_kelas_rusak_total = (isset($row['ruang_kelas_rusak_total']) && is_numeric($row['ruang_kelas_rusak_total'])) ? $row['ruang_kelas_rusak_total'] : 0;
            $jml_ruang_kelas = (isset($row['jml_ruang_kelas']) && is_numeric($row['jml_ruang_kelas'])) ? $row['jml_ruang_kelas'] : 0;
            $ruang_perpus_baik = (isset($row['ruang_perpus_baik']) && is_numeric($row['ruang_perpus_baik'])) ? $row['ruang_perpus_baik'] : 0;
            $ruang_perpus_rusak_ringan = (isset($row['ruang_perpus_rusak_ringan']) && is_numeric($row['ruang_perpus_rusak_ringan'])) ? $row['ruang_perpus_rusak_ringan'] : 0;
            $ruang_perpus_rusak_sedang = (isset($row['ruang_perpus_rusak_sedang']) && is_numeric($row['ruang_perpus_rusak_sedang'])) ? $row['ruang_perpus_rusak_sedang'] : 0;
            $ruang_perpus_rusak_berat = (isset($row['ruang_perpus_rusak_berat']) && is_numeric($row['ruang_perpus_rusak_berat'])) ? $row['ruang_perpus_rusak_berat'] : 0;
            $ruang_perpus_rusak_total = (isset($row['ruang_perpus_rusak_total']) && is_numeric($row['ruang_perpus_rusak_total'])) ? $row['ruang_perpus_rusak_total'] : 0;
            $jml_ruang_perpus = (isset($row['jml_ruang_perpus']) && is_numeric($row['jml_ruang_perpus'])) ? $row['jml_ruang_perpus'] : 0;

            $created_by = \Auth()->user()->id;

            $save = DapodikSekolahRuangKelasModel::create([
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'ruang_kelas_baik' => $ruang_kelas_baik,
                'ruang_kelas_rusak_ringan' => $ruang_kelas_rusak_ringan,
                'ruang_kelas_rusak_sedang' => $ruang_kelas_rusak_sedang,
                'ruang_kelas_rusak_berat' => $ruang_kelas_rusak_berat,
                'ruang_kelas_rusak_total' => $ruang_kelas_rusak_total,
                'jml_ruang_kelas' => $jml_ruang_kelas,
                'ruang_perpus_baik' => $ruang_perpus_baik,
                'ruang_perpus_rusak_ringan' => $ruang_perpus_rusak_ringan,
                'ruang_perpus_rusak_sedang' => $ruang_perpus_rusak_sedang,
                'ruang_perpus_rusak_berat' => $ruang_perpus_rusak_berat,
                'ruang_perpus_rusak_total' => $ruang_perpus_rusak_total,
                'jml_ruang_perpus' => $jml_ruang_perpus,
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
