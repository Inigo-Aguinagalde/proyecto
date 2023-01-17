<?php

namespace App\Console;

use App\Models\InsertData;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


        if (!Schema::hasTable('compañias')) {
            Schema::create('compañias', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
            });
            $schedule->command('db:seed --class=compañiasSeeder');
        };

        if (!Schema::hasTable('bolsa')) {
            Schema::create('bolsa', function (Blueprint $table) {
                $table->uuid('id');
                $table->timestamp('created_at');
                $table->float('variacion');
                $table->float('Euros');
                $table->foreignUuid('compañia_id');
            });
            Schema::table('bolsa', function (Blueprint $table) {
                $table->foreign('compañia_id')
                    ->references('id')
                    ->on('compañias')
                    ->onDelete('cascade');
            });
            $schedule->command('db:seed --class=BolsaSeeder');
        };

        $schedule->job(function () {
            // if (Carbon::now()->addHour() <= '21:00:00' && Carbon::now()->addHour() >= '09:00:00') {

            $companiaIDs = DB::table('compañias')->pluck('id');
            $var = 0;
            foreach ($companiaIDs as $element) {

                $datos = DB::table('bolsa')->where('compañia_id', $element)->latest()->first();
                // error_log($datos->variation);
                // error_log($datos->Euros);
                // error_log($datos->compañia_id);
                // error_log(Carbon::now()->addHour());
                $randomVariation = (rand(-500, 500) / 10000) * 5; // Generates a random decimal between -5% and 5%
                $datos->variacion = round($randomVariation, 2);
                $datos->Euros = round($datos->Euros + ($datos->Euros * $datos->variacion), 2);

                $var = $var + 1;
                DB::table('bolsa')->insert([
                    'id' => Str::uuid()->toString(),
                    'created_at' =>   Carbon::now()->addHour(),
                    'variacion' => $datos->variacion,
                    'Euros' => $datos->Euros,
                    'compañia_id' => $datos->compañia_id,
                ]);
            }

            // }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
