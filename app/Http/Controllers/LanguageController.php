<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Class LanguageController
 * @package App\Http\Controllers
 */
class LanguageController extends Controller
{
	/**
	 * Create a new instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Make sure we have a language set
		$currentLanguageCode = Session::get('languageCode', Language::getDefaultLanguageCode());
		if (!isset($currentLanguageCode)) {
			Session::put('languageCode', Language::getDefaultLanguageCode());
		}
	}

	/**
	 * Change the selected language
	 */
	public function changeLanguage(Request $request)
	{
		// Change the selected language
		$data = Input::get();
		$lang = [];
		if (isset($data) && isset($data['languageCode'])) {
			$lang = Language::where('code', "=", $data['languageCode'])->firstOrFail();

			Session::put('languageCode', $data['languageCode']);
		}

		return $lang;
	}

}
