<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsertData extends Controller
{
    public function generateData(){
        $data = DB::table('datos')->select('uuid', 'compañia_id', 'euros', 'variacion')->get();
        foreach ($data as $item) {
            $randomVariation = (rand(-500, 500) / 10000) * 5; // Generates a random decimal between -5% and 5%
            $item->variation = $randomVariation;
            $item->euros = $item->euros + ($item->euros * $item->variation);
            DB::table('datos')->insert([
                'uuid' => $item->uuid,
                'compañia_id' => $item->compañia_id,
                'variation' => $item->variation,
                'euros' => $item->euros,
                'fecha' =>  DB::raw('CURRENT_TIMESTAMP'),
            ]);
        }
    }
}
