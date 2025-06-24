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
use Modules\Dapodik\Models\DapodikSekolahSiswaModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahSiswaRekapClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */


    private $rows = 0;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $jks = collect(['l','p']);
            $nama_sekolah = (isset($row['nama_sekolah']) && $row['nama_sekolah'] <> 'null') ? $row['nama_sekolah'] : NULL;
            $npsn = (isset($row['npsn']) && $row['npsn'] <> 'null') ? $row['npsn'] : NULL;
            $peserta_didik_baru = (isset($row['peserta_didik_baru']) && is_numeric($row['peserta_didik_baru'])) ? $row['peserta_didik_baru'] : NULL;
            $peserta_didik_lulus = (isset($row['peserta_didik_lulus']) && is_numeric($row['peserta_didik_lulus'])) ? $row['peserta_didik_lulus'] : NULL;
            $peserta_didik_putus = (isset($row['peserta_didik_putus']) && is_numeric($row['peserta_didik_putus'])) ? $row['peserta_didik_putus'] : NULL;
            $peserta_didik_mengulang = (isset($row['peserta_didik_mengulang']) && is_numeric($row['peserta_didik_mengulang'])) ? $row['peserta_didik_mengulang'] : NULL;
            $add_data = [
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'peserta_didik_baru' => $peserta_didik_baru,
                'peserta_didik_lulus' => $peserta_didik_lulus,
                'peserta_didik_putus' => $peserta_didik_putus,
                'peserta_didik_mengulang' => $peserta_didik_mengulang
            ];

            $fields = collect(['tka','tkb']);
            foreach ($fields as $field){
                foreach ($jks as $jk){
                    ${$field.'_'.$jk} = (isset($row[$field.'_'.$jk]) && is_numeric($row[$field.'_'.$jk])) ? $row[$field.'_'.$jk] : NULL;
                    $add_data = array_merge($add_data,[
                        $field.'_'.$jk => ${$field.'_'.$jk}
                    ]);
                }
            }

            for ($i = 1; $i <= 13; $i++) {
                foreach ($jks as $jk){
                    ${'t'.$i.'_'.$jk} = (isset($row['t'.$i.'_'.$jk]) && is_numeric($row['t'.$i.'_'.$jk])) ? $row['t'.$i.'_'.$jk] : NULL;
                    $add_data = array_merge($add_data,[
                        't'.$i.'_'.$jk => ${'t'.$i.'_'.$jk}
                    ]);
                }
            }

            $fields = collect(['pkt_a','pkt_b','pkt_c']);
            foreach ($fields as $field){
                foreach ($jks as $jk){
                    ${$field.'_'.$jk} = (isset($row[$field.'_'.$jk]) && is_numeric($row[$field.'_'.$jk])) ? $row[$field.'_'.$jk] : NULL;
                    $add_data = array_merge($add_data,[
                        $field.'_'.$jk => ${$field.'_'.$jk}
                    ]);
                }
            }

            $fields = collect(['pd']);
            foreach ($fields as $field){
                foreach ($jks as $jk){
                    ${$field.'_'.$jk} = (isset($row[$field.'_'.$jk]) && is_numeric($row[$field.'_'.$jk])) ? $row[$field.'_'.$jk] : NULL;
                    $add_data = array_merge($add_data,[
                        $field.'_'.$jk => ${$field.'_'.$jk}
                    ]);
                }
            }

            $pd_total = (isset($row['pd_total']) && is_numeric($row['pd_total'])) ? $row['pd_total'] : NULL;
            $add_data = array_merge($add_data,[
                'pd_total' => $pd_total
            ]);

            for ($i = 0; $i <= 21; $i++) {
                foreach ($jks as $jk){
                    ${'u'.$i.'_'.$jk} = (isset($row['u'.$i.'_'.$jk]) && is_numeric($row['u'.$i.'_'.$jk])) ? $row['u'.$i.'_'.$jk] : NULL;
                    $add_data = array_merge($add_data,[
                        'u'.$i.'_'.$jk => ${'u'.$i.'_'.$jk}
                    ]);
                }
            }

            $fields = collect(['islam','kristen','katholik','hindu','budha','konghucu','kepercayaan','agama_lain']);
            foreach ($fields as $field){
                foreach ($jks as $jk){
                    ${$jk.'_'.$field} = (isset($row[$jk.'_'.$field]) && is_numeric($row[$jk.'_'.$field])) ? $row[$jk.'_'.$field] : 0;
                    $add_data = array_merge($add_data,[
                        $jk.'_'.$field => ${$jk.'_'.$field}
                    ]);
                }
            }

            $fields = collect(['lulus','mutasi','dikeluarkan','mundur','putus','wafat','hilang','lainnya']);
            foreach ($fields as $field){
                foreach ($jks as $jk){
                    ${$jk.'_'.$field} = (isset($row[$jk.'_'.$field]) && is_numeric($row[$jk.'_'.$field])) ? $row[$jk.'_'.$field] : NULL;
                    $add_data = array_merge($add_data,[
                        $jk.'_'.$field => ${$jk.'_'.$field}
                    ]);
                }
            }

            $created_by = \Auth()->user()->id;
            $add_data = array_merge($add_data,[
                'created_by' => $created_by
            ]);

            $save = DapodikSekolahSiswaModel::create($add_data);
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
