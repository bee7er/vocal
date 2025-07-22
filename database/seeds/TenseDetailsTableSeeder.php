<?php

use Illuminate\Database\Seeder;
use App\TenseDetail;
use Illuminate\Support\Facades\DB;

class TenseDetailsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('tense_details')->delete();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'passé composé', 'lang' => 'fr'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/past_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'présent', 'lang' => 'fr'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/present_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'imparfait', 'lang' => 'fr'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/imperfect_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'futur simple', 'lang' => 'fr'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/future_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'plus-que-parfait', 'lang' => 'fr'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'fr')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/pluperfect_tense_french.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'presente', 'lang' => 'it'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/present_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'passato prossimo', 'lang' => 'it'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/past_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'imperfetto', 'lang' => 'it'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/imperfect_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'futuro', 'lang' => 'it'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/future_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'trapassato prossimo', 'lang' => 'it'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'it')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/pluperfect_tense_italian.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'presente', 'lang' => 'es'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'es')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/present_tense_spanish.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'pasada', 'lang' => 'es'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'es')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/past_tense_spanish.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'imperfecta', 'lang' => 'es'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'es')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/imperfect_tense_spanish.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'futura', 'lang' => 'es'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'es')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/future_tense_spanish.pdf';
        $tenseDetail->save();

        $tenseDetail = new TenseDetail();
        $tenseDetail->tense_id = DB::table('tenses')->where(['tense' => 'pluscuamperfecto', 'lang' => 'es'])->get()[0]->id;
        $tenseDetail->language_id = DB::table('langs')->where('code', '=', 'es')->get()[0]->id;
        $tenseDetail->pdf = '/pdfs/pluperfect_tense_spanish.pdf';
        $tenseDetail->save();
    }

}
