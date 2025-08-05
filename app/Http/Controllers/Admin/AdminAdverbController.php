<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdverbController;
use App\Http\Controllers\Controller;
use App\Language;
use App\Adverb;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AdminAdverbController
 * @package App\Http\Controllers
 */
class AdminAdverbController extends Controller
{
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Show the application adverb page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request, $position=null, $filter=null)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$adverbs = $this->getAdverbs($request, $languageCode, trim($position), trim($filter));

		return view('pages.admin.workWithAdverbs', compact('position', 'filter', 'currentLanguage',
			'languageCode', 'languages', 'adverbs', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Add an adverb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function addAdverb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$adverb = null;
		try {
			$adverb = $this->getAdverb($request);
			$adverb->lang = $languageCode;		// Default to current language

		} catch(Exception $e) {
			Log::notice("Error getting adverb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adverb with id {$request->get('adverbId')}";
		}

		$title = "Add Adverb";
		$button = "Add";

		return view('pages.admin.editAdverb', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'adverb', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Edit an adverb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editAdverb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$adverb = null;
		try {
			$adverb = $this->getAdverb($request, $request->get('adverbId'));
		} catch(Exception $e) {
			Log::notice("Error getting adverb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adverb with id {$request->get('adverbId')}";
		}

		$title = "Edit Adverb";
		$button = "Update";
		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToAdverb = urlAction();

		return view('pages.admin.editAdverb', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'adverb', 'loggedIn', 'returnToAdverb', 'errors', 'msgs'));
	}

	/**
	 * Deletes an adverb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function deleteAdverb(Request $request)
	{
		$languageCode = self::getCurrentLanguageCode();
		$adverb = $pos = $fil = null;
		try {
			$adverbId = $request->get('adverbId');

			$adverb = $this->getAdverb($request, $adverbId);
			// We will position back to where this entry was
			$pos = $adverb->adverb;
			$fil = '';

			$adverb->delete();

		} catch(Exception $e) {
			Log::notice("Error deleting adverb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
		}

		return Redirect::to("/workWithAdverbs/$pos/$fil");
	}

	/**
	 * Updates an adverb.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function updateAdverb(Request $request)
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$errors = [];
		$msgs = [];
		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$adverbId = $request->get('adverbId');
		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToAdverb = $request->get('returnToAdverb');

		$adverb = $pos = $fil = null;
		try {
			if (isset($adverbId) && is_numeric($adverbId) && $adverbId > 0) {
				$adverb = $this->getAdverb($request, $adverbId);
				$adverb->adverb = $request->get('adverb');
				$adverb->english = $request->get('english');
				$adverb->lang = $request->get('language');
				$adverb->save();

				$pos = $adverb->adverb;

			} else {
				$adverbAry = [
					"adverb" => $request->get('adverb'),
					"english" => $request->get('english'),
					"lang" => $request->get('language'),
				];
				Adverb::create($adverbAry);

				$pos = $adverbAry["adverb"];
				$fil = '';
			}

		} catch(Exception $e) {
			Log::notice("Error getting adverb: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adverb with id {$request->get('adverbId')}";

			$title = $request->get('title');
			$button = $request->get('button');

			return view('pages.admin.editAdverb', compact('title', 'button', 'currentLanguage',
				'languageCode', 'languages', 'adverb', 'loggedIn', 'returnToAdverb', 'errors', 'msgs'));
		}

		if ('workWithAdverbs' != $returnToAdverb) {
			// We have come from the play-with function, return there
			$request->merge(["returnToAdverbId" => $adverbId]);

			return (new AdverbController($this->auth))->index($request);
		}

		return Redirect::to("/workWithAdverbs/$pos/$fil");
	}

	/**
	 * Retrieve an adverb from the db table
	 */
	private function getAdverb(Request $request, $id=null)
	{
		if (null == $id) {
			// Add mode
			return new Adverb();
		}

		// Change mode
		return Adverb::findOrFail(
			$id,
			array(
				'adverbs.id',
				'adverbs.adverb',
				'adverbs.english',
				'adverbs.lang',
			)
		);
	}

	/**
	 * Retrieve all adverbs from the db table
	 */
	private function getAdverbs($request, $languageCode, $position=null, $filter=null)
	{
		$builder = Adverb::select(
			array(
				'adverbs.id',
				'adverbs.adverb',
				'adverbs.english',
				'adverbs.lang',
			)
		);

		if (null != $position) {
			$builder->where("adverbs.adverb", ">=", $position);
		}

		if (null != $filter) {
			$builder->where("adverbs.adverb", "LIKE", ("%$filter%"));
		}

		$adverbs = $builder
			->where("adverbs.lang", "=", $languageCode)
			->orderBy('adverbs.adverb')
			->get();

		return $adverbs;
	}

}
