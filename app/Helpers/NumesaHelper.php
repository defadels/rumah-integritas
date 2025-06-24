<?php

namespace App\Helpers;

use Modules\Master\Models\KecamatanModel;
use Modules\Users\Models\LogsModel;
use Illuminate\Support\Facades\Log;

class NumesaHelper
{

    public static function log($level, $pesan, $uid)
    {
        switch ($level) {
            case 'INFO':
                Log::info($level, [$pesan]);
                break;
            case 'WARNING':
                Log::warning($level, [$pesan]);
                break;
            case 'ERROR':
                Log::error($level, [$pesan]);
                break;
            case 'DEBUG':
                Log::debug($level, [$pesan]);
                break;
            case 'CRITICAL':
                Log::critical($level, [$pesan]);
                break;
            default:
                throw new \Exception('Format Log tidak benar');
        }
        LogsModel::create([
            'env' => env('APP_ENV', 'env tidak set'),
            'message' => $pesan,
            'level' => $level,
            'context' => $pesan,
            'extra' => '-',
            'uid' => $uid,
            'ip_address' => \Request::ip()
        ]);
    }

    public static function comboAktif($current = '')
    {
        $strOut = '';
        if ($current == '1') :
            $strOut .= '<option value="1" selected="selected">Aktif</option>' . "\n";
        else :
            $strOut .= '<option value="1">Aktif</option>' . "\n";
        endif;
        if ($current == '0') :
            $strOut .= '<option value="0" selected="selected">Suspend</option>' . "\n";
        else :
            $strOut .= '<option value="0">Suspend</option>' . "\n";
        endif;
        return $strOut;
    }

    public static function comboKecamatan($current='')
    {
        $strOut = '';
        $listdata = KecamatanModel::get();
        foreach ($listdata as $row){
            if ( $current == $row->id ) :
                $strOut .= '<option value="'.$row->id.'" selected="selected">'.$row->nama_kecamatan.'</option>'."\n";
            else :
                $strOut .= '<option value="'.$row->id.'">'.$row->nama_kecamatan.'</option>'."\n";
            endif;
        }
        return $strOut;
    }

    public static function nomorInteger($number)
    {
        if ($number != '') {
            $number = str_replace('.', '', $number);
        } else {
            $number = null;
        }
        return $number;
    }

    public static function nomorFloat($number)
    {
        if ($number != '') {
            $number = str_replace('.', '', $number);
            $number = str_replace(',', '.', $number);
            $number = (float)$number;
        } else {
            $number = null;
        }
        return $number;
    }

}
