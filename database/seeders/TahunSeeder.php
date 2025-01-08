<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $tahunData = [
                ['tahun' => 2020],
                ['tahun' => 2021],
                ['tahun' => 2022],
                ['tahun' => 2023],
                ['tahun' => 2024],
            ];

            DB::table('tahun')->insert($tahunData);
        }
    }
}