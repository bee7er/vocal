<?php

namespace App\Http\Controllers;

use App\Language;
use App\Person;
use App\Tense;
use App\TenseDetail;
use App\Verb;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class VerbController
 * @package App\Http\Controllers
 */
class VerbController extends Controller
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
	 * Show the application verb page to the user.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request, $includeFormFields=true)
	{

//		print_r($this->test());
//		dd('done');

		$verb = $this->getVerb($request);
		$tense = $this->getTense($request);
		$person = $this->getPerson($request);
		$tenseDetail = $this->getTenseDetail($request, $tense);

		return $this->returnView($request, $verb, $tense, $person, $tenseDetail, $includeFormFields);
	}

	public function test()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.google.com/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		curl_close($ch);

		echo $response;
	}

	/**
	 * Check submitted answers
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function checkAnswers(Request $request)
	{
        // Validate response to the verb/tense/person combination
		$englishInfinitive = strtolower(trim($request->get("englishInfinitive")));
		$englishConjugation = strtolower(trim($request->get("englishConjugation")));
		$foreignConjugation = strtolower(trim($request->get("foreignConjugation")));
		$speak = $request->get('speak');

		// Represent the same verb/tense/person
		$verb = $this->getVerb($request, $request->get("verbId"));
		$tense = $this->getTense($request, $request->get("tenseId"));
		$person = $this->getPerson($request, $request->get("personId"));
		$tenseDetail = $this->getTenseDetail($request, $tense);

		$errors = $msgs = [];
		if ("" == $englishInfinitive) {
			$errors[] = 'English infinitive is required';
		}
		elseif ("to" == $englishInfinitive) {
			$errors[] = "English infinitive requires more than just 'to'";
		} else {
			if (!$this->validEnglishInfinitive($englishInfinitive, $verb)) {
				$errors[] = "Could not find English infinitive in the corresponding verb details. Consider editing the verb details.";
			}
		}
		if ("" == $englishConjugation) {
			$errors[] = 'English conjugation is required';
		}
		if ("" == $foreignConjugation) {
			$errors[] = 'Foreign conjugation is required';
		}
		if (null === $speak) {
			$errors[] = 'Give the speaking of the foreign conjugation a go!';
		}

		if (0 >= count($errors)) {
			$msgs[] = "Looking good. Move onto the next verb.";
		}

		return $this->returnView($request, $verb, $tense, $person, $tenseDetail, true, $errors, $msgs);
	}

	/**
	 * Validate the English infinitive of the verb
	 */
	private function validEnglishInfinitive($englishInfinitive, $verb)
	{
		// Split up the response from the user
		// Ignore 'to', as irrelevant
		$wordFound = false;
		// Check that any other words appear in the English version of the verb
		$responseWords = explode(' ', $englishInfinitive);
		foreach ($responseWords as $responseWord) {
			if ('to' === $responseWord) {
				continue;
			}
			// Here we add a space at the end of the english version of the adverb, so
			// that we can do a string search for the full word
			if (strpos(($verb['english'] . ' '), ($responseWord . ' ')) !== false) {
				$wordFound = true;
			}
			// Words can be separated by semi-colons, too, so try that
			if (strpos(($verb['english'] . ';'), ($responseWord . ';')) !== false) {
				$wordFound = true;
			}
		}

		return $wordFound;
	}

	/**
	 * Present a new verb
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function nextVerb(Request $request)
	{
        // Generate and return a new verb, tense and person combination
		return $this->index($request, false);
	}

	/**
	 * Retrieve the remaining form variables and the view
	 *
	 * @param Request $request
	 * @return Response
	 */
	private function returnView(Request $request, $verb, $tense, $person, $tenseDetail, $includeFormFields, $errors=[], $msgs=[])
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$languageCode = self::getCurrentLanguageCode();
		$languages = Language::getLanguages();
		$currentLanguage = self::getCurrentLanguage();

		$englishInfinitive = '';
		$englishConjugation = '';
		$foreignConjugation = '';
		$speak = null;
		if ($includeFormFields) {
			$englishInfinitive = $request->get("englishInfinitive");
			$englishConjugation = $request->get("englishConjugation");
			$foreignConjugation = $request->get("foreignConjugation");
			$speak = $request->get('speak');
		}

		// I wanted to allow verb.blade.php to close a popup window, but this would not work
		// The opened window was set to 'closed: true' which prevents this interaction
		//header("Cross-Origin-Opener-Policy: noopener-allow-popups");

		$translateWdwTip = self::TRANSLATE_WDW_TIP;

		return view('pages.verb', compact('currentLanguage', 'languageCode', 'languages', 'verb', 'tense', 'person', 'tenseDetail',
			'englishInfinitive', 'englishConjugation', 'foreignConjugation', 'speak', 'loggedIn', 'errors', 'msgs', 'translateWdwTip'));
	}

	/**
	 * Retrieve a verb from the db table at random
	 */
	private function getVerb($request, $id = null)
	{
		$builder = Verb::select(
			array(
				'verbs.id',
				'verbs.infinitive',
				'verbs.english',
				'verbs.reflexive',
				'verbs.lang',
			)
		);
		if (null !== $id) {
			$verb = $builder->where("verbs.id", "=", $id)->get();
		} else {
			$verb = $builder
				->where("verbs.lang", "=", self::getCurrentLanguageCode())
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

		// Returning just the data in an array
		return (isset($verb[0]) ? $verb->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getTense($request, $id = null)
	{
		$builder = Tense::select(
			array(
				'tenses.id',
				'tenses.tense',
				'tenses.english',
				'tenses.lang',
			)
		);
		if (null !== $id) {
			$tense = $builder->where("tenses.id", "=", $id)->get();
		} else {
			$tense = $builder
				->where("tenses.lang", "=", self::getCurrentLanguageCode())
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

        // Returning just the data in an array
        return (isset($tense[0]) ? $tense->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense detail from the db table
	 */
	private function getTenseDetail($request, $tense)
	{
		$language = self::getCurrentLanguage($request);

		$builder = TenseDetail::select(
			array(
				'tense_details.id',
				'tense_details.tense_id',
				'tense_details.language_id',
				'tense_details.pdf',
			)
		);
		$tenseDetail = $builder
			->where("tense_details.tense_id", "=", $tense['id'])
			->where("tense_details.language_id", "=", $language->id)->get();

        // Returning just the data in an array
        return (isset($tenseDetail[0]) ? $tenseDetail->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getPerson($request, $id = null)
	{
		$builder = Person::select(
			array(
				'persons.id',
				'persons.person',
				'persons.english',
				'persons.lang',
			)
		);
		if (null !== $id) {
			$person = $builder->where("persons.id", "=", $id)->get();
		} else {
			$person = $builder
				->where("persons.lang", "=", self::getCurrentLanguageCode())
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

        // Returning just the data in an array
        return (isset($person[0]) ? $person->toArray()[0]: null);
	}

}
