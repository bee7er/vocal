<?php

namespace App\Http\Controllers;

use App\Language;
use App\Adjective;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class AdjectiveController
 * @package App\Http\Controllers
 */
class AdjectiveController extends Controller
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
	public function index(Request $request, $includeFormFields=true)
	{
		$adjective = $this->getAdjective($request);

		return $this->returnView($request, $adjective, $includeFormFields);
	}

	/**
	 * Present a new adjective
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function nextAdjective(Request $request)
	{
		// Generate and return a new adjective
		return $this->index($request, false);
	}

	/**
	 * Check submitted answers
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function checkAnswers(Request $request)
	{
        // Validate response to the adjective
		$englishAdjective = strtolower(trim($request->get("englishAdjective")));
		$adjective = $this->getAdjective($request, $request->get("adjectiveId"));

		$errors = $msgs = [];
		if ("" == $englishAdjective) {
			$errors[] = 'English version of adjective is required';
		} else {
			if (!$this->validEnglishAdjective($englishAdjective, $adjective)) {
				$errors[] = "Could not find English adjective in the corresponding adjective details";
			}
		}

		if (0 >= count($errors)) {
			$msgs[] = "Your translation was correct";
		}

		return $this->returnView($request, $adjective, true, $errors, $msgs);
	}

	/**
	 * Validate the English version of the adjective
	 */
	private function validEnglishAdjective($englishAdjective, $adjective)
	{
		// Split up the response from the user
		$wordFound = false;
		// Check that at least one of the words appears in the English version of the adjective
		$responseWords = explode(' ', $englishAdjective);
		foreach ($responseWords as $responseWord) {
			// Here we add a space at the end of the english version of the adjective, so
			// that we can do a string search for the full word
			if (strpos(($adjective['english'] . ' '), ($responseWord . ' ')) !== false) {
				$wordFound = true;
			}
			// Words can be separated by semi-colons, too, so try that
			if (strpos(($adjective['english'] . ';'), ($responseWord . ';')) !== false) {
				$wordFound = true;
			}
		}

		return $wordFound;
	}

	/**
	 * Retrieve the remaining form variables and the view
	 *
	 * @param Request $request
	 * @return Response
	 */
	private function returnView(Request $request, $adjective, $includeFormFields, $errors=[], $msgs=[])
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$languageCode = $request->get('languageCode', Language::getDefaultLanguageCode());
		$languages = Language::getLanguages();
		$currentLanguage = Language::getCurrentLanguage($request);

		$englishAdjective = '';
		if ($includeFormFields) {
			$englishAdjective = $request->get("englishAdjective");
		}

		return view('pages.adjective', compact('currentLanguage', 'languageCode', 'languages', 'adjective',
			'englishAdjective', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Retrieve a adjective from the db table at random
	 */
	private function getAdjective(Request $request, $id = null)
	{
		$builder = Adjective::select(
			array(
				'adjectives.id',
				'adjectives.adjective',
				'adjectives.english',
				'adjectives.lang',
			)
		);
		if (null !== $id) {
			$adjective = $builder->where("adjectives.id", "=", $id)->get();
		} else {
			$adjective = $builder
				->where("adjectives.lang", "=", $request->get('languageCode', Language::getDefaultLanguageCode()))
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

		// Returning just the data in an array
		return (isset($adjective[0]) ? $adjective->toArray()[0]: null);
	}

}
