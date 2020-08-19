<?php

use Illuminate\Database\Seeder;

class ReportReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report_reasons')->insert([
            'reason' => 'Bad Language'
        ]);

        DB::table('report_reasons')->insert([
            'reason' => 'Sexual Assault'
        ]);

        DB::table('report_reasons')->insert([
            'reason' => 'Gender Discrimination'
        ]);

        DB::table('report_reasons')->insert([
            'reason' => 'Racism'
        ]);

        DB::table('report_reasons')->insert([
            'reason' => 'Porn Words/Images'
        ]);
    }
}
