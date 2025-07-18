<?php

use Illuminate\Database\Seeder;
use App\Tense;
use Illuminate\Support\Facades\DB;

class TensesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tenses')->delete();

        $tense = new Tense();
        $tense->tense = 'présent';
        $tense->english = 'present';
        $tense->lang = 'fr';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'passé composé';
        $tense->english = 'present perfect';
        $tense->lang = 'fr';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'imparfait';
        $tense->english = 'imperfect';
        $tense->lang = 'fr';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'futur simple';
        $tense->english = 'future';
        $tense->lang = 'fr';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'plus-que-parfait';
        $tense->english = 'pluperfect';
        $tense->lang = 'fr';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'presente';
        $tense->english = 'present';
        $tense->lang = 'it';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'presente prossimo';
        $tense->english = 'present perfect';
        $tense->lang = 'it';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'imperfetto';
        $tense->english = 'imperfect';
        $tense->lang = 'it';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'futuro';
        $tense->english = 'future';
        $tense->lang = 'it';
        $tense->save();

        $tense = new Tense();
        $tense->tense = 'trapassato prossimo';
        $tense->english = 'pluperfect';
        $tense->lang = 'it';
        $tense->save();

    }

}
