<?php

namespace Modules\ReportServices\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ReportServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $data;

    public function index(Request $request)
    {
      $type = decrypt($request->type);
      $title = '';
      $table='';

      switch ($type) {
        case '1':
          $title='PENGAJUAN MAKAN MINUM';
          $table='form_konsumsi';
          $this->data = DB::table($table)->get();
          break;
        case '2':
          $title='HASIL PEMERIKSAAN AWAL';
          $table='form_hasil_periksa';
          $this->data = DB::select("select h.id,h.name keterangan,(select name from users where id=h.users_id) pengirim,(select name from users where id=h.users_receiver) penerima, h.users_id, h.users_receiver, h.created_at from form_hasil_periksa h left join users u on u.id=h.users_id where h.users_id=u.id or h.users_receiver=u.id order by h.created_at");
          break;
        case '3':
          $title='PEMELIHARAAN BMD';
          $table='form_pelihara';
          $this->data = DB::select("select f.name pengusul, j.name jenis_pemeliharaan, f.jenis_keluhan keluhan, f.sub_bag, f.created_at from form_pelihara f left join jenis_pemeliharaan j on j.id=f.jenis_pelihara");
          break;
        case '4':
          $title='AGENDA INSPEKTORAT';
          $table='form_barang_pakai_habis';
          $this->data = DB::table($table)->get();
          break;
        case '5':
          $title='KARTU KENDALI';
          $table='form_kartu_kendali';
          $this->data = DB::table($table)->get();
          break;

        default:
          $title='Something Wrong';
          break;
      }

      $data = $this->data;
      if($type==2){
        $data = DB::select("select h.id,h.name keterangan,(select name from users where id=h.users_id) pengirim,(select name from users where id=h.users_receiver) penerima, h.users_id, h.users_receiver, h.created_at from form_hasil_periksa h left join users u on u.id=h.users_id where h.users_id=u.id or h.users_receiver=u.id order by h.created_at");
      }

      $template = $this->generate_pdf($type,$data);

        $html = "
            <html>
            <head>
            <style>
            body {font-family: 'Times New Roman', sans-serif;
                font-size: 10pt;
            }
            p {	margin: 0pt; }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { vertical-align: top; }
            .items td {
                border: 0.1mm solid #495057;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #495057;
                font-variant: small-caps;
            }
            .items td.blanktotal {
                background-color: #EEEEEE;
                border: 0.1mm solid #000000;
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
            .items td.cost {
                text-align: '.' center;
            }
            </style>
            </head>
            <body>

            <!--mpdf
            <htmlpageheader name='myheader'>
            <table width='100%'><tr>
            <td width='10%' style='text-align: right'><img src='assets/images/logo-kop.png' width='96'></td>
            <td width='80%' style='text-align: center'>

            <span style='font-size: 12pt; font-weight:bold;'>PEMERINTAH KOTA BALIKPAPAN</span><br/>
            <span style='font-size: 16pt; font-weight:bold;'>INSPEKTORAT</span> <br/>
            <p>Jl. RUHUI RAHAYU I Telp./Fax. (0542) 7218734 KOTAK POS 1111</p>
            <span style='font-size: 10pt; font-weight:bold;'>BALIKPAPAN  76115</span> <br/>
            <span style='font-size: 10pt;'>Email: inskot.balikpapan@yahoo.co.id</span> <br/>
            </td>
            </tr></table>
            <div style='border-bottom: 1px solid #000000; padding-bottom: 3mm; '></div>
            </htmlpageheader>

            <htmlpagefooter name='myfooter'>
            <div style='border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; '>
            Page {PAGENO} of {nb}
            </div>
            </htmlpagefooter>

            <sethtmlpageheader name='myheader' value='on' show-this-page='1' />
            <sethtmlpagefooter name='myfooter' value='on' />
            mpdf-->

            <div style='text-align: center; margin-bottom:2pt;'>REKAP DATA {$title}</div><br/>

            <table class='items' width='100%' style='font-size: 9pt; border-collapse: collapse;' cellpadding='8'>
            {$template}
            </table>
            <br/>
            <div style='text-align: right; margin-top:5pt;'>Balikpapan, 22-11-2024</div>
            <div style='text-align: right;'>Kepala Inspektorat</div><br/><br/><br/>
            <div style='text-align: right;'>(..........................)</div>
            </body>
            </html>
            ";

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 48,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        if($type==2){
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 20,
                'margin_right' => 15,
                'margin_top' => 48,
                'margin_bottom' => 25,
                'margin_header' => 10,
                'margin_footer' => 10
            ]);
        }

        $mpdf->showImageErrors = true;
        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle($title);
        $mpdf->SetAuthor("Inspektorat");
        $mpdf->SetWatermarkText("Inspektorat");
        // $mpdf->SetWatermarkImage(asset('assets/themes/material60/assets/images/logo-balikpapan.png'),0.2,'F');
        // $mpdf->showWatermarkImage = true;
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output();
        // return view('reportservices::index');
    }

    protected function generate_pdf($type,$data){
        switch ($type) {
            case '1':
                return $this->template_konsumsi($data);
                break;
            case '2':
                return $this->template_hasil_pemeriksaan($data);
                break;
            case '3':
                return $this->template_pemeliharaan_bmd($data);
                break;
            case '4':
                return $this->template_barang_pakai_habis($data);
                break;
            case '5':
                return $this->template_kartu_kendali($data);
                break;

            default:
                return "Not found";
                break;
        }
    }

    protected function template_konsumsi($data){
        $thead = "
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Kegiatan</td>
                        <td>Tanggal Pelaksanaan</td>
                        <td>Jumlah Konsumsi</td>
                        <td>Pengusul</td>
                    </tr>
                </thead>
                ";
        $row="";
        foreach ($data as $key => $value) {
            $no = $key+1;
            $row.="
                <tr>
                    <td>{$no}</td>
                    <td>{$value->judul_rapat}</td>
                    <td>{$value->waktu}</td>
                    <td>{$value->jml_konsumsi}</td>
                    <td>{$value->name}</td>
                </tr>
            ";
        }
        $tbody ="
                <tbody>
                    {$row}
                </tbody>
            ";
        $html = $thead . $tbody;
        return $html;
    }

    protected function template_hasil_pemeriksaan($data){
        $thead = "
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Pengirim</td>
                        <td>OPD Penerima</td>
                        <td>Tanggal</td>
                        <td>Keterangan</td>
                    </tr>
                </thead>
                ";
        $row="";
        foreach ($data as $key => $value) {
            $no = $key+1;
            $date = date_create($value->created_at);
            $date = date_format($date,'d-m-Y');
            $row.="
                <tr>
                    <td>{$no}</td>
                    <td>{$value->pengirim}</td>
                    <td>{$value->penerima}</td>
                    <td>{$date}</td>
                    <td>{$value->keterangan}</td>
                </tr>
            ";
        }
        $tbody ="
                <tbody>
                    {$row}
                </tbody>
            ";
        $html = $thead . $tbody;
        return $html;
    }

    protected function template_pemeliharaan_bmd($data){
        $thead = "
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Pemeliharaan</td>
                        <td>Jenis Keluhan</td>
                        <td>Sub Bagian</td>
                        <td>Pengusul</td>
                        <td>Tanggal</td>
                    </tr>
                </thead>
                ";
        $row="";
        foreach ($data as $key => $value) {
            $no = $key+1;
            $date = date_create($value->created_at);
            $date = date_format($date,'d-m-Y');
            $row.="
                <tr>
                    <td>{$no}</td>
                    <td>{$value->jenis_pemeliharaan}</td>
                    <td>{$value->keluhan}</td>
                    <td>{$value->sub_bag}</td>
                    <td>{$value->pengusul}</td>
                    <td>{$date}</td>
                </tr>
            ";
        }
        $tbody ="
                <tbody>
                    {$row}
                </tbody>
            ";
        $html = $thead . $tbody;
        return $html;
    }

    protected function template_barang_pakai_habis($data){
        $thead = "
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Kegiatan</td>
                        <td>Waktu Pelaksanaan</td>
                        <td>Jam Pelaksanaan</td>
                        <td>Lokasi Kegiatan</td>
                        <td>Penanggung Jawab</td>
                        <td>Email</td>
                        <td>Tanggal</td>
                    </tr>
                </thead>
                ";
        $row="";
        foreach ($data as $key => $value) {
            $no = $key+1;
            $date = date_create($value->created_at);
            $date = date_format($date,'d-m-Y');
            $row.="
                <tr>
                    <td>{$no}</td>
                    <td>{$value->namakegiatan}</td>
                    <td>{$value->tanggalpelaksanaan}</td>
                    <td>{$value->waktupelaksanaan}</td>
                    <td>{$value->lokasikegiatan}</td>
                    <td>{$value->penanggungjawab}</td>
                    <td>{$value->email}</td>
                    <td>{$date}</td>
                </tr>
            ";
        }
        $tbody ="
                <tbody>
                    {$row}
                </tbody>
            ";
        $html = $thead . $tbody;
        return $html;
    }

    protected function template_kartu_kendali($data){
        $thead = "
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Kodesub</td>
                        <td>Pekerjaan</td>
                        <td>Subkegiatan</td>
                        <td>Subbidang</td>
                        <td>Rekanan</td>
                        <td>BAP</td>
                        <td>Tanggal BAP</td>
                        <td>SPK</td>
                        <td>Pagu</td>
                        <td>Tanggal</td>
                    </tr>
                </thead>
                ";
        $row="";
        foreach ($data as $key => $value) {
            $no = $key+1;
            $date = date_create($value->created_at);
            $date = date_format($date,'d-m-Y');
            $row.="
                <tr>
                    <td>{$no}</td>
                    <td>{$value->kode_sub}</td>
                    <td>{$value->pekerjaan}</td>
                    <td>{$value->sub_kegiatan}</td>
                    <td>{$value->sub_bidang}</td>
                    <td>{$value->rekanan}</td>
                    <td>{$value->bap_no}</td>
                    <td>{$value->bap_tgl}</td>
                    <td>{$value->spk_no}</td>
                    <td>{$value->pagu_dana}</td>
                    <td>{$date}</td>
                </tr>
            ";
        }
        $tbody ="
                <tbody>
                    {$row}
                </tbody>
            ";
        $html = $thead . $tbody;
        return $html;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reportservices::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('reportservices::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('reportservices::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
