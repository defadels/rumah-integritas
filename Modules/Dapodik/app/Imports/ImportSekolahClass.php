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

class ImportSekolahClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param Collection $collection
    */


    private $rows = 0;
    private $kec;

    public function __construct($kec)
    {
        $this->kec = $kec;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
            $nama_sekolah = (isset($row['nama_sekolah']) && $row['nama_sekolah'] <> 'null') ? $row['nama_sekolah'] : NULL;
            $npsn = (isset($row['npsn']) && $row['npsn'] <> 'null') ? $row['npsn'] : NULL;
            $status = (isset($row['status']) && $row['status'] <> 'null') ? $row['status'] : 'null';
            $bentuk = (isset($row['bentuk']) && $row['bentuk'] <> 'null') ? $row['bentuk'] : 'null';
            $alamat = (isset($row['alamat']) && $row['alamat'] <> 'null') ? $row['alamat'] : 'null';
            $kecamatan = (isset($row['kecamatan']) && $row['kecamatan'] <> 'null') ? $row['kecamatan'] : NULL;
            $kode_registrasi = (isset($row['kode_registrasi']) && $row['kode_registrasi'] <> 'null') ? $row['kode_registrasi'] : NULL;
            $created_by = \Auth()->user()->id;

            /*echo $nama_lengkap.' | '.$npsn.' | '.$kecamatan.' | '.$kabupaten.' | '.$jk.' | '.$nik.' | '.$nuptk.' | '.$nip.
                ' | '.$no_hp.' | '.$jam_mengajar.' | '.$jabatan_kepsek.'<br><br>';*/

            $save = DapodikSekolahModel::create([
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'status' => $status,
                'bentuk' => $bentuk,
                'alamat' => $alamat,
                'kecamatan' => $kecamatan,
                'kecamatan_id' => $this->kec,
                'kabupaten_id' => config('app.kab_id'),
                'provinsi_id' => config('app.prov_id'),
                'kode_reg' => $kode_registrasi,
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
