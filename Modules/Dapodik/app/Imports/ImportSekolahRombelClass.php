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
use Modules\Dapodik\Models\DapodikSekolahAdministrasiModel;
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahRombelModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahRombelClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
            $rombel_t1 = (isset($row['rombel_t1']) && is_numeric($row['rombel_t1'])) ? $row['rombel_t1'] : NULL;
            $rombel_t2 = (isset($row['rombel_t2']) && is_numeric($row['rombel_t2'])) ? $row['rombel_t2'] : NULL;
            $rombel_t3 = (isset($row['rombel_t3']) && is_numeric($row['rombel_t3'])) ? $row['rombel_t3'] : NULL;
            $rombel_t4 = (isset($row['rombel_t4']) && is_numeric($row['rombel_t4'])) ? $row['rombel_t4'] : NULL;
            $rombel_t5 = (isset($row['rombel_t5']) && is_numeric($row['rombel_t5'])) ? $row['rombel_t5'] : NULL;
            $rombel_t6 = (isset($row['rombel_t6']) && is_numeric($row['rombel_t6'])) ? $row['rombel_t6'] : NULL;
            $rombel_t7 = (isset($row['rombel_t7']) && is_numeric($row['rombel_t7'])) ? $row['rombel_t7'] : NULL;
            $rombel_t8 = (isset($row['rombel_t8']) && is_numeric($row['rombel_t8'])) ? $row['rombel_t8'] : NULL;
            $rombel_t9 = (isset($row['rombel_t9']) && is_numeric($row['rombel_t9'])) ? $row['rombel_t9'] : NULL;
            $rombel_t10 = (isset($row['rombel_t10']) && is_numeric($row['rombel_t10'])) ? $row['rombel_t10'] : NULL;
            $rombel_t11 = (isset($row['rombel_t11']) && is_numeric($row['rombel_t11'])) ? $row['rombel_t11'] : NULL;
            $rombel_t12 = (isset($row['rombel_t12']) && is_numeric($row['rombel_t12'])) ? $row['rombel_t12'] : NULL;
            $rombel_t13 = (isset($row['rombel_t13']) && is_numeric($row['rombel_t13'])) ? $row['rombel_t13'] : NULL;
            $rombel_tka = (isset($row['rombel_tka']) && is_numeric($row['rombel_tka'])) ? $row['rombel_tka'] : NULL;
            $rombel_tkb = (isset($row['rombel_tkb']) && is_numeric($row['rombel_tkb'])) ? $row['rombel_tkb'] : NULL;
            $rombel_pkt_a = (isset($row['rombel_pkt_a']) && is_numeric($row['rombel_pkt_a'])) ? $row['rombel_pkt_a'] : NULL;
            $rombel_pkt_b = (isset($row['rombel_pkt_b']) && is_numeric($row['rombel_pkt_b'])) ? $row['rombel_pkt_b'] : NULL;
            $rombel_pkt_c = (isset($row['rombel_pkt_c']) && is_numeric($row['rombel_pkt_c'])) ? $row['rombel_pkt_c'] : NULL;
            $jml_rombel = (isset($row['jml_rombel']) && is_numeric($row['jml_rombel'])) ? $row['jml_rombel'] : NULL;

            $created_by = \Auth()->user()->id;

            //echo $nama_sekolah.' | '.$npsn.' | '.$rombel_t1.'='.$row['rombel_t1'].'<br><br>';

            $save = DapodikSekolahRombelModel::create([
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'rombel_t1' => $rombel_t1,
                'rombel_t2' => $rombel_t2,
                'rombel_t3' => $rombel_t3,
                'rombel_t4' => $rombel_t4,
                'rombel_t5' => $rombel_t5,
                'rombel_t6' => $rombel_t6,
                'rombel_t7' => $rombel_t7,
                'rombel_t8' => $rombel_t8,
                'rombel_t9' => $rombel_t9,
                'rombel_t10' => $rombel_t10,
                'rombel_t11' => $rombel_t11,
                'rombel_t12' => $rombel_t12,
                'rombel_t13' => $rombel_t13,
                'rombel_tka' => $rombel_tka,
                'rombel_tkb' => $rombel_tkb,
                'rombel_pkt_a' => $rombel_pkt_a,
                'rombel_pkt_b' => $rombel_pkt_b,
                'rombel_pkt_c' => $rombel_pkt_c,
                'jml_rombel' => $jml_rombel,
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
