<?php

namespace Modules\Dapodik\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;

class ImportKepalaSekolahClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
            $kecamatan = (isset($row['kecamatan']) && $row['kecamatan'] <> 'null') ? $row['kecamatan'] : NULL;
            $kabupaten = (isset($row['kabupaten']) && $row['kabupaten'] <> 'null') ? $row['kabupaten'] : NULL;
            $nama_lengkap = (isset($row['nama_kepsek']) && $row['nama_kepsek'] <> 'null') ? $row['nama_kepsek'] : 'null';
            $jk = (isset($row['jk']) && $row['jk'] <> 'null') ? $row['jk'] : NULL;
            $nik = (isset($row['nik']) && $row['nik'] <> 'null') ? $row['nik'] : NULL;
            $nuptk = (isset($row['nuptk']) && $row['nuptk'] <> 'null') ? $row['nuptk'] : NULL;
            $nip = (isset($row['nip']) && $row['nip'] <> 'null') ? $row['nip'] : NULL;
            $no_sk = (isset($row['no_sk']) && $row['no_sk'] <> 'null') ? $row['no_sk'] : NULL;
            $tmt_kepala = (isset($row['tmt_kepala_sekolah']) && $row['tmt_kepala_sekolah'] <> 'null') ? $row['tmt_kepala_sekolah'] : NULL;
            $no_hp = (isset($row['no_hp']) && $row['no_hp'] <> 'null') ? $row['no_hp'] : NULL;
            $email = (isset($row['email']) && $row['email'] <> 'null') ? $row['email'] : NULL;
            $status_kepsek = (isset($row['status_kepsek']) && $row['status_kepsek'] <> 'null') ? $row['status_kepsek'] : NULL;
            $created_by = \Auth()->user()->id;

            /*echo $nama_sekolah.' | '.$npsn.' | '.$kecamatan.' | '.$kabupaten.' | '.$nama_lengkap.' | '.$jk.' | '.$nik.' | '.$nuptk.' | '.$nip.
                ' | '.$no_sk.' | '.$tmt_kepala.' | '.$no_hp.' | '.$email.' | '.$status_kepsek.'<br><br>';*/

            $save = DapodikKepalaSekolahModel::create([
                'nama_lengkap' => $nama_lengkap,
                'jk' => $jk,
                'nik' => $nik,
                'nuptk' => $nuptk,
                'nip' => $nip,
                'no_sk' => $no_sk,
                'tmt_kepala' => $tmt_kepala,
                'no_hp' => $no_hp,
                'email' => $email,
                'status_kepsek' => $status_kepsek,
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'kecamatan' => $kecamatan,
                'kabupaten' => $kabupaten,
                'created_by' => $created_by
            ]);
            ++$this->rows;
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
