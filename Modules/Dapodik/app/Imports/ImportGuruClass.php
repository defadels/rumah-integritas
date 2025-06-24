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

class ImportGuruClass implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
            $nama_lengkap = (isset($row['nama_lengkap']) && $row['nama_lengkap'] <> 'null') ? $row['nama_lengkap'] : NULL;
            $nik = (isset($row['nik']) && $row['nik'] <> 'null') ? $row['nik'] : NULL;
            $nuptk = (isset($row['nuptk']) && $row['nuptk'] <> 'null') ? $row['nuptk'] : NULL;
            $nip = (isset($row['nip']) && $row['nip'] <> 'null') ? $row['nip'] : NULL;
            $jk = (isset($row['jk']) && $row['jk'] <> 'null') ? $row['jk'] : NULL;
            $tmp_lahir = (isset($row['tmp_lahir']) && $row['tmp_lahir'] <> 'null') ? $row['tmp_lahir'] : NULL;
            $tgl_lahir = (isset($row['tgl_lahir']) && $row['tgl_lahir'] <> '1/1/1900' && $row['tgl_lahir'] <> 'null') ? DateTime::createFromFormat('j/n/y', ($row['tgl_lahir'])) : NULL;
            $status_tugas = (isset($row['status_tugas']) && $row['status_tugas'] <> 'null') ? $row['status_tugas'] : NULL;
            $tmp_tugas = (isset($row['tmp_tugas']) && $row['tmp_tugas'] <> 'null') ? $row['tmp_tugas'] : NULL;
            $npsn = (isset($row['npsn']) && $row['npsn'] <> 'null') ? $row['npsn'] : NULL;
            $kecamatan = (isset($row['kecamatan']) && $row['kecamatan'] <> 'null') ? $row['kecamatan'] : NULL;
            $kabupaten = (isset($row['kabupaten']) && $row['kabupaten'] <> 'null') ? $row['kabupaten'] : NULL;
            $no_hp = (isset($row['no_hp']) && $row['no_hp'] <> 'null') ? $row['no_hp'] : NULL;
            $sk_cpns = (isset($row['sk_cpns']) && $row['sk_cpns'] <> 'null') ? $row['sk_cpns'] : NULL;
            $tgl_cpns = (isset($row['tgl_cpns']) && $row['tgl_cpns'] <> '1/1/1900' && $row['tgl_cpns'] <> 'null') ? DateTime::createFromFormat('j/n/y', ($row['tgl_cpns'])) : NULL;
            $sk_pengangkatan = (isset($row['sk_pengangkatan']) && $row['sk_pengangkatan'] <> 'null') ? $row['sk_pengangkatan'] : NULL;
            $tmt_pengangkatan = (isset($row['tmt_pengangkatan']) && $row['tmt_pengangkatan'] <> '1/1/1900' && $row['tmt_pengangkatan'] <> 'null') ? DateTime::createFromFormat('j/n/y', ($row['tmt_pengangkatan'])) : NULL;
            $jenis_ptk = (isset($row['jenis_ptk']) && $row['jenis_ptk'] <> 'null') ? $row['jenis_ptk'] : NULL;
            $pendidikan = (isset($row['pendidikan']) && $row['pendidikan'] <> 'null') ? $row['pendidikan'] : NULL;
            $bidang_studi_pendidikan = (isset($row['bidang_studi_pendidikan']) && $row['bidang_studi_pendidikan'] <> 'null') ? $row['bidang_studi_pendidikan'] : 'null';
            $bidang_studi_sertifikasi = (isset($row['bidang_studi_sertifikasi']) && $row['bidang_studi_sertifikasi'] <> 'null') ? $row['bidang_studi_sertifikasi'] : 'null';
            $status_kepegawaian = (isset($row['status_kepegawaian']) && $row['status_kepegawaian'] <> 'null') ? $row['status_kepegawaian'] : 'null';
            $pangkat_gol = (isset($row['pangkat_gol']) && $row['pangkat_gol'] <> 'null') ? $row['pangkat_gol'] : NULL;
            $tmt_pangkat = (isset($row['tmt_pangkat']) && $row['tmt_pangkat'] <> '1/1/1900' && $row['tmt_pangkat'] <> 'null') ? DateTime::createFromFormat('j/n/y', ($row['tmt_pangkat'])) : NULL;
            $masa_kerja_tahun = (isset($row['masa_kerja_tahun']) && $row['masa_kerja_tahun'] <> 'null') ? $row['masa_kerja_tahun'] : NULL;
            $masa_kerja_bulan = (isset($row['masa_kerja_bulan']) && $row['masa_kerja_bulan'] <> 'null') ? $row['masa_kerja_bulan'] : NULL;
            $mata_pelajaran = (isset($row['mata_pelajaran']) && $row['mata_pelajaran'] <> 'null') ? $row['mata_pelajaran'] : NULL;
            $jam_mengajar = (isset($row['jam_mengajar']) && $row['jam_mengajar'] <> 'null') ? $row['jam_mengajar'] : NULL;
            $jabatan_kepsek = (isset($row['jabatan_kepsek']) && $row['jabatan_kepsek'] <> 'null') ? $row['jabatan_kepsek'] : NULL;
            $created_by = \Auth()->user()->id;


            /*echo $nama_lengkap.' | '.$npsn.' | '.$kecamatan.' | '.$kabupaten.' | '.$jk.' | '.$nik.' | '.$nuptk.' | '.$nip.
                ' | '.$no_hp.' | '.$jam_mengajar.' | '.$jabatan_kepsek.'<br><br>';*/

            $save = DapodikGuruModel::create([
                'nama_lengkap' => $nama_lengkap,
                'nik' => $nik,
                'nuptk' => $nuptk,
                'nip' => $nip,
                'jk' => $jk,
                'tmp_lahir' => $tmp_lahir,
                'tgl_lahir' => $tgl_lahir,
                'status_tugas' => $status_tugas,
                'tmp_tugas' => $tmp_tugas,
                'npsn' => $npsn,
                'kecamatan' => $kecamatan,
                'kabupaten' => $kabupaten,
                'kecamatan_id' => $this->kec,
                'kabupaten_id' => config('app.kab_id'),
                'provinsi_id' => config('app.prov_id'),
                'no_hp' => $no_hp,
                'sk_cpns' => $sk_cpns,
                'tgl_cpns' => $tgl_cpns,
                'sk_pengangkatan' => $sk_pengangkatan,
                'tmt_pengangkatan' => $tmt_pengangkatan,
                'jenis_ptk' => $jenis_ptk,
                'pendidikan' => $pendidikan,
                'bidang_studi_pendidikan' => $bidang_studi_pendidikan,
                'bidang_studi_sertifikasi' => $bidang_studi_sertifikasi,
                'status_kepegawaian' => $status_kepegawaian,
                'pangkat_gol' => $pangkat_gol,
                'tmt_pangkat' => $tmt_pangkat,
                'masa_kerja_tahun' => $masa_kerja_tahun,
                'masa_kerja_bulan' => $masa_kerja_bulan,
                'mata_pelajaran' => $mata_pelajaran,
                'jam_mengajar' => $jam_mengajar,
                'jabatan_kepsek' => $jabatan_kepsek,
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
