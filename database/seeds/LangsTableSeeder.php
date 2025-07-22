<?php

use Illuminate\Database\Seeder;
use App\Language;
use Illuminate\Support\Facades\DB;

class LangsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('langs')->delete();

        $lang = new Language();
        $lang->language = 'french';
        $lang->code = 'fr';
        $lang->flag = '/images/french.png';
        $lang->save();

        $lang = new Language();
        $lang->language = 'italian';
        $lang->code = 'it';
        $lang->flag = '/images/italian.png';
        $lang->save();

        $lang = new Language();
        $lang->language = 'spanish';
        $lang->code = 'es';
        $lang->flag = '/images/spanish.png';
        $lang->save();
    }

}
