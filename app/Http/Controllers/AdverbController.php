<?php

namespace App\Http\Controllers;

use App\Language;
use App\Adverb;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * Class AdverbController
 * @package App\Http\Controllers
 */
class AdverbController extends Controller
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
	public function index(Request $request, $includeFormFields=true)
	{
		$adverb = $this->getAdverb($request);

		return $this->returnView($request, $adverb, $includeFormFields);
	}

	/**
	 * Present a new adverb
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function nextAdverb(Request $request)
	{
		// Generate and return a new adverb
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
        // Validate response to the adverb
		$englishAdverb = strtolower(trim($request->get("englishAdverb")));
		$adverb = $this->getAdverb($request, $request->get("adverbId"));

		$errors = $msgs = [];
		if ("" == $englishAdverb) {
			$errors[] = 'English version of adverb is required';
		} else {
			if (!$this->validEnglishAdverb($englishAdverb, $adverb)) {
				$errors[] = "Could not find English adverb in the corresponding adverb details";
			}
		}

		if (0 >= count($errors)) {
			$msgs[] = "Your translation was correct";
		}

		return $this->returnView($request, $adverb, true, $errors, $msgs);
	}

	/**
	 * Validate the English version of the adverb
	 */
	private function validEnglishAdverb($englishAdverb, $adverb)
	{
		// Split up the response from the user
		$wordFound = false;
		// Check that at least one of the words appears in the English version of the adverb
		$responseWords = explode(' ', $englishAdverb);
		foreach ($responseWords as $responseWord) {
			// Here we add a space at the end of the english version of the adverb, so
			// that we can do a string search for the full word
			if (strpos(($adverb['english'] . ' '), ($responseWord . ' ')) !== false) {
				$wordFound = true;
			}
			// Words can be separated by semi-colons, too, so try that
			if (strpos(($adverb['english'] . ';'), ($responseWord . ';')) !== false) {
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
	private function returnView(Request $request, $adverb, $includeFormFields, $errors=[], $msgs=[])
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$languageCode = $request->get('languageCode', Language::getDefaultLanguageCode());
		$languages = Language::getLanguages();
		$currentLanguage = Language::getCurrentLanguage($request);

		$englishAdverb = '';
		if ($includeFormFields) {
			$englishAdverb = $request->get("englishAdverb");
		}

		return view('pages.adverb', compact('currentLanguage', 'languageCode', 'languages', 'adverb',
			'englishAdverb', 'loggedIn', 'errors', 'msgs'));
	}

	/**
	 * Retrieve a adverb from the db table at random
	 */
	private function getAdverb(Request $request, $id = null)
	{
		$builder = Adverb::select(
			array(
				'adverbs.id',
				'adverbs.adverb',
				'adverbs.english',
				'adverbs.lang',
			)
		);
		if (null !== $id) {
			$adverb = $builder->where("adverbs.id", "=", $id)->get();
		} else {
			$adverb = $builder
				->where("adverbs.lang", "=", $request->get('languageCode', Language::getDefaultLanguageCode()))
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

		// Returning just the data in an array
		return (isset($adverb[0]) ? $adverb->toArray()[0]: null);
	}

}
