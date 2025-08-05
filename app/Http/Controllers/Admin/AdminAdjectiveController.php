<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdjectiveController;
use App\Http\Controllers\Controller;
use App\Language;
use App\Adjective;
use Exception;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

/**
 * Class AdminAdjectiveController
 * @package App\Http\Controllers
 */
class AdminAdjectiveController extends Controller
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
	 * Show the application adjective page to the user.
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

		$adjectives = $this->getAdjectives($request, $languageCode, trim($position), trim($filter));

		return view('pages.admin.workWithAdjectives', compact('position', 'filter', 'currentLanguage',
			'languageCode', 'languages', 'adjectives', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Add an adjective.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function addAdjective(Request $request)
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

		$adjective = null;
		try {
			$adjective = $this->getAdjective($request);
			$adjective->lang = $languageCode;		// Default to current language

		} catch(Exception $e) {
			Log::notice("Error getting adjective: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adjective with id {$request->get('adjectiveId')}";
		}

		$title = "Add Adjective";
		$button = "Add";

		return view('pages.admin.editAdjective', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'adjective', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Edit an adjective.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function editAdjective(Request $request)
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

		$adjective = null;
		try {
			$adjective = $this->getAdjective($request, $request->get('adjectiveId'));
		} catch(Exception $e) {
			Log::notice("Error getting adjective: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adjective with id {$request->get('adjectiveId')}";
		}

		$title = "Edit Adjective";
		$button = "Update";
		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToAdjective = urlAction();

		return view('pages.admin.editAdjective', compact('title', 'button', 'currentLanguage',
			'languageCode', 'languages', 'adjective', 'loggedIn', 'returnToAdjective' , 'errors', 'msgs'));
	}

	/**
	 * Deletes an adjective.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function deleteAdjective(Request $request)
	{
		$languageCode = self::getCurrentLanguageCode();
		$adjective = $pos = $fil = null;
		try {
			$adjectiveId = $request->get('adjectiveId');

			$adjective = $this->getAdjective($request, $adjectiveId);
			// We will position back to where this entry was
			$pos = $adjective->adjective;
			$fil = '';

			$adjective->delete();

		} catch(Exception $e) {
			Log::notice("Error deleting adjective: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
		}

		return Redirect::to("/workWithAdjectives/$pos/$fil");
	}

	/**
	 * Updates an adjective.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function updateAdjective(Request $request)
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

		$adjectiveId = $request->get('adjectiveId');

		$adjective = $pos = $fil = null;
		try {
			if (isset($adjectiveId) && is_numeric($adjectiveId) && $adjectiveId > 0) {
				$adjective = $this->getAdjective($request, $adjectiveId);
				$adjective->adjective = $request->get('adjective');
				$adjective->english = $request->get('english');
				$adjective->lang = $request->get('language');
				$adjective->save();

				$pos = $adjective->adjective;

			} else {
				$adjectiveAry = [
					"adjective" => $request->get('adjective'),
					"english" => $request->get('english'),
					"lang" => $request->get('language'),
				];
				Adjective::create($adjectiveAry);

				$pos = $adjectiveAry["adjective"];
				$fil = '';
			}

		} catch(Exception $e) {
			Log::notice("Error getting adjective: {$e->getMessage()} at {$e->getFile()}, {$e->getLine()}");
			$errors[] = "Error finding adjective with id {$request->get('adjectiveId')}";

			$title = $request->get('title');
			$button = $request->get('button');

			return view('pages.admin.editAdjective', compact('title', 'button', 'currentLanguage',
				'languageCode', 'languages', 'adjective', 'loggedIn', 'errors', 'msgs'));
		}

		// We may have navigated here from the play-with function, if so we want to return there.
		$returnToAdjective = $request->get('returnToAdjective');
		if ('workWithAdjectives' != $returnToAdjective) {
			// We have come from the play-with function, return there
			$request->merge(["returnToAdjectiveId" => $adjectiveId]);

			return (new AdjectiveController($this->auth))->index($request);
		}

		return Redirect::to("/workWithAdjectives/$pos/$fil");
	}

	/**
	 * Retrieve an adjective from the db table
	 */
	private function getAdjective(Request $request, $id=null)
	{
		if (null == $id) {
			// Add mode
			return new Adjective();
		}

		// Change mode
		return Adjective::findOrFail(
			$id,
			array(
				'adjectives.id',
				'adjectives.adjective',
				'adjectives.english',
				'adjectives.lang',
			)
		);
	}

	/**
	 * Retrieve all adjectives from the db table
	 */
	private function getAdjectives($request, $language, $position=null, $filter=null)
	{
		$builder = Adjective::select(
			array(
				'adjectives.id',
				'adjectives.adjective',
				'adjectives.english',
				'adjectives.lang',
			)
		);

		if (null != $position) {
			$builder->where("adjectives.adjective", ">=", $position);
		}

		if (null != $filter) {
			$builder->where("adjectives.adjective", "LIKE", ("%$filter%"));
		}

		$adjectives = $builder
			->where("adjectives.lang", "=", self::getCurrentLanguageCode())
			->orderBy('adjectives.adjective')
			->get();

		return $adjectives;
	}

}
