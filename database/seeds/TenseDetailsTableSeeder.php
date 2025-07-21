<?php

use Illuminate\Database\Seeder;
use App\TenseDetail;
use Illuminate\Support\Facades\DB;

class TenseDetailsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tense_details')->delete();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'présent')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->details = 'some data';
        $tenseDetail->save();
    }

}
