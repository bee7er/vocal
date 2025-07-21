<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
	public function __construct(Request $request)
	{
		// Make sure we have a language set
		$currentLanguageCode = $request->get('languageCode', Language::getDefaultLanguageCode());
		if (!isset($currentLanguageCode)) {
			$request->request->add(['languageCode' => Language::getDefaultLanguageCode()]);
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

			$request->request->add(['languageCode' => $data['languageCode']]);
		}

		return $lang;
	}

	/**
	 * testing popup
	 */
	public function getInfo(Request $request)
	{
		return response()->json([
			'success' => 1,
			'data' => '/pdfs/past_tense_french.pdf',
		]);
	}

}
