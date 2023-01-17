<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InsertData extends Model
{
    use HasFactory;



    // public function generateData() {
    //     $data = DB::table('bolsa')->select('id', 'compañia_id', 'Euros', 'variacion')->get();
    //     foreach ($data as $item) {
    //         $randomVariation = (rand(-500, 500) / 10000) * 5; // Generates a random decimal between -5% and 5%
    //         $item->variation = round($randomVariation,2);
    //         $item->Euros = round($item->Euros + ($item->Euros * $item->variation),2);
    //         error_log($item->variation);
    //         error_log($item->Euros);
    //         error_log($item->compañia_id);
    //         error_log(Carbon::now()->addHour());
    //         DB::table('bolsa')->insert([
    //             'id' => Str::uuid()->toString(),
    //             'fecha' =>   Carbon::now(),
    //             'variacion' => $item->variation,
    //             'Euros' => $item->Euros,
    //             'compañia_id' => $item->compañia_id,                    
    //         ]);
    //     }
    // }



}
