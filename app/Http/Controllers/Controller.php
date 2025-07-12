<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Make sure we have a language set
        $currentLanguageCode = Session::get('languageCode');
        if (!isset($currentLanguageCode)) {
            Session::put('languageCode', $this->getDefaultLanguageCode());
        }
    }

    /**
     * Retrieve the default language code
     */
    public function getDefaultLanguageCode()
    {
        return config('app.default_language_code');
    }

    /**
     * Change the selected language
     */
    public function changeLanguage(Request $request)
    {
        // Change the selected language
        $data = Input::get();


        Log::notice(print_r($data, true));

        $lang = [];
        if (isset($data) && isset($data['languageCode'])) {
            $lang = Language::where('code', "=", $data['languageCode'])->firstOrFail();

            Session::put('languageCode', $data['languageCode']);
        }

        return $lang;
    }
}
