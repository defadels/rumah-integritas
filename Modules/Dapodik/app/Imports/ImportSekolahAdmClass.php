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
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportSekolahAdmClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
            $bentuk_pendidikan = (isset($row['bentuk_pendidikan']) && $row['bentuk_pendidikan'] <> 'null') ? $row['bentuk_pendidikan'] : NULL;
            $status_sekolah = (isset($row['status_sekolah']) && $row['status_sekolah'] <> 'null') ? $row['status_sekolah'] : NULL;
            $alamat = (isset($row['alamat']) && $row['alamat'] <> 'null') ? $row['alamat'] : NULL;
            $kelurahan = (isset($row['kelurahan']) && $row['kelurahan'] <> 'null') ? $row['kelurahan'] : NULL;
            $kecamatan = (isset($row['kecamatan']) && $row['kecamatan'] <> 'null') ? $row['kecamatan'] : NULL;
            $kabupaten = (isset($row['kabupaten']) && $row['kabupaten'] <> 'null') ? $row['kabupaten'] : NULL;
            $provinsi = (isset($row['provinsi']) && $row['provinsi'] <> 'null') ? $row['provinsi'] : NULL;
            $kodepos = (isset($row['kodepos']) && $row['kodepos'] <> 'null') ? $row['kodepos'] : NULL;
            $lintang = (isset($row['lintang']) && $row['lintang'] <> 'null') ? $row['lintang'] : NULL;
            $bujur = (isset($row['bujur']) && $row['bujur'] <> 'null') ? $row['bujur'] : NULL;
            $no_telp = (isset($row['no_telp']) && $row['no_telp'] <> 'null') ? '0'.$row['no_telp'] : NULL;
            $npwp = (isset($row['npwp']) && $row['npwp'] <> 'null') ? $row['npwp'] : NULL;
            $nama_kepsek = (isset($row['nama_kepsek']) && $row['nama_kepsek'] <> 'null') ? $row['nama_kepsek'] : NULL;
            $nip_kepsek = (isset($row['nip_kepsek']) && $row['nip_kepsek'] <> 'null') ? sprintf('%.0f', $row['nip_kepsek']) : NULL;
            $no_hp_kepsek = (isset($row['no_hp_kepsek']) && $row['no_hp_kepsek'] <> 'null') ? '0'.$row['no_hp_kepsek'] : NULL;
            $email_kepsek = (isset($row['email_kepsek']) && $row['email_kepsek'] <> 'null') ? $row['email_kepsek'] : NULL;
            $status_kepsek = (isset($row['status_kepsek']) && $row['status_kepsek'] <> 'null') ? $row['status_kepsek'] : NULL;
            $periode_data = (isset($row['periode_data']) && $row['periode_data'] <> 'null') ? $row['periode_data'] : NULL;
            $tmt_akreditasi = (isset($row['tmt_akreditasi']) && $row['tmt_akreditasi'] <> 1 && is_numeric($row['tmt_akreditasi'])) ? Date::excelToDateTimeObject($row['tmt_akreditasi'])->format('Y-m-d') : NULL;
            $akreditasi = (isset($row['akreditasi']) && $row['akreditasi'] <> 'null') ? $row['akreditasi'] : NULL;
            $nama_operator = (isset($row['nama_operator']) && $row['nama_operator'] <> 'null') ? $row['nama_operator'] : NULL;
            $email_operator = (isset($row['email_operator']) && $row['email_operator'] <> 'null') ? $row['email_operator'] : NULL;
            $no_hp_operator = (isset($row['no_hp_operator']) && $row['no_hp_operator'] <> 'null') ? '0'.$row['no_hp_operator'] : NULL;
            $sinkron_terakhir = (isset($row['sinkron_terakhir']) && $row['sinkron_terakhir'] <> 1 && is_numeric($row['sinkron_terakhir'])) ? Date::excelToDateTimeObject($row['sinkron_terakhir'])->format('Y-m-d H:i:s') : NULL;
            $bendahara_bos = (isset($row['bendahara_bos']) && $row['bendahara_bos'] <> 'null') ? $row['bendahara_bos'] : NULL;
            $created_by = \Auth()->user()->id;

            //echo $nama_sekolah.' | '.$npsn.' | '.$nip_kepsek.'<br><br>';

            $save = DapodikSekolahAdministrasiModel::create([
                'nama_sekolah' => $nama_sekolah,
                'npsn' => $npsn,
                'bentuk_pendidikan' => $bentuk_pendidikan,
                'status_sekolah' => $status_sekolah,
                'alamat' => $alamat,
                'kelurahan' => $kelurahan,
                'kecamatan' => $kecamatan,
                'kabupaten' => $kabupaten,
                'provinsi' => $provinsi,
                'kabupaten_id' => config('app.kab_id'),
                'provinsi_id' => config('app.prov_id'),
                'kodepos' => $kodepos,
                'lintang' => $lintang,
                'bujur' => $bujur,
                'no_telp' => $no_telp,
                'npwp' => $npwp,
                'nama_kepsek' => $nama_kepsek,
                'nip_kepsek' => $nip_kepsek,
                'no_hp_kepsek' => $no_hp_kepsek,
                'email_kepsek' => $email_kepsek,
                'status_kepsek' => $status_kepsek,
                'periode_data' => $periode_data,
                'tmt_akreditasi' => $tmt_akreditasi,
                'akreditasi' => $akreditasi,
                'nama_operator' => $nama_operator,
                'email_operator' => $email_operator,
                'no_hp_operator' => $no_hp_operator,
                'sinkron_terakhir' => $sinkron_terakhir,
                'bendahara_bos' => $bendahara_bos,
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
