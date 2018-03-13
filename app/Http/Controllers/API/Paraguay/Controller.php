<?php

namespace App\Http\Controllers\API\Paraguay;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function calculateDV($taxID)
    {
        $base_max = 11;
        $array_ruc = str_split($ruc);
        $n = count($array_ruc);

        $suma = 0;
        $k = 2;

        for ($i = $n - 1; $i >= 0; $i--)
        {
            if (is_numeric($array_ruc[$i]))
            {
                $k = $k > $base_max ? 2 : $k;
                $suma += ($array_ruc[$i] * $k++);
            }
        }

        $v_resto = $suma % 11;
        $dv = $v_resto > 1 ? 11 - $v_resto : 0;
        return $dv;
    }
}
