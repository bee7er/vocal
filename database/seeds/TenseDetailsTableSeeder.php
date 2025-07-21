<?php

use Illuminate\Database\Seeder;
use App\TenseDetail;
use Illuminate\Support\Facades\DB;

class TenseDetailsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tense_details')->delete();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'passé composé')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/past_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'présent')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/present_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'imparfait')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/imperfect_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'futur simple')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/future_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'plus-que-parfait')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/pluperfect_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'presente')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/present_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'passato prossimo')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/past_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'imperfetto')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/imperfect_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'futuro')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/future_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where('tense', '=', 'trapassato prossimo')->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/pluperfect_tense_italian.pdf';
        $tenseDetail->save();
    }

}
