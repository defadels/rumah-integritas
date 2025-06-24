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
use Modules\Dapodik\Models\DapodikSekolahRuangGuruModel;
use Modules\Dapodik\Models\DapodikSekolahRuangKelasModel;
use Modules\Dapodik\Models\DapodikSekolahWcModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahWcClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */


    private $rows = 0;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $kondisis = collect(['baik','rusak_ringan','rusak_sedang','rusak_berat','rusak_total']);
            $nama_sekolah = (isset($row['nama_sekolah']) && $row['nama_sekolah'] <> 'null') ? $row['nama_sekolah'] : NULL;
            $npsn = (isset($row['npsn']) && $row['npsn'] <> 'null') ? $row['npsn'] : NULL;
            $add_data = [
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn
            ];

            $fields = collect(['wc_guru_laki','wc_guru_perempuan','wc_siswa_laki','wc_siswa_perempuan']);
            foreach ($fields as $field){
                foreach ($kondisis as $kondisi){
                    ${$field.'_'.$kondisi} = (isset($row[$field.'_'.$kondisi]) && is_numeric($row[$field.'_'.$kondisi])) ? $row[$field.'_'.$kondisi] : 0;
                    $add_data = array_merge($add_data,[
                        $field.'_'.$kondisi => ${$field.'_'.$kondisi}
                    ]);
                }
                ${'jml_'.$field} = (isset($row['jml_'.$field]) && is_numeric($row['jml_'.$field])) ? $row['jml_'.$field] : 0;
                $add_data = array_merge($add_data,[
                    'jml_'.$field => ${'jml_'.$field}
                ]);
            }

            $created_by = \Auth()->user()->id;
            $add_data = array_merge($add_data,[
                'created_by' => $created_by
            ]);

            $save = DapodikSekolahWcModel::create($add_data);
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
