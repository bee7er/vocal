<?php

namespace App\Http\Controllers;

use App\Language;
use App\Person;
use App\Tense;
use App\Verb;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
	public function index(Request $request)
	{

//		print_r($this->test());
//		dd('done');

		$verb = $this->getVerb();
		$tense = $this->getTense();
		$person = $this->getPerson();

		return $this->returnView($request, $verb, $tense, $person);
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
		$verb = $this->getVerb($request->get("verbId"));
		$tense = $this->getTense($request->get("tenseId"));
		$person = $this->getPerson($request->get("personId"));

		$errors = [];
		if ("" == $englishInfinitive) {
			$errors[] = 'English infinitive is required';
		}
		elseif ("to" == $englishInfinitive) {
			$errors[] = "English infinitive requires more than just 'to'";
		} else {
			if (!$this->validEnglishInfinitive($englishInfinitive, $verb)) {
				$errors[] = "Could not find English infinitive in the corresponding verb details";
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

		return $this->returnView($request, $verb, $tense, $person, $errors);
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
			// Check that at least one other word appears in the englisg versio of the verb
			if (strpos($verb['english'], $responseWord) !== false) {
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
		return $this->index($request);
	}

	/**
	 * Retrieve the remaining form variables and the view
	 *
	 * @param Request $request
	 * @return Response
	 */
	private function returnView(Request $request, $verb, $tense, $person, $errors=[])
	{
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

		$languageCode = Session::get('languageCode', Language::getDefaultLanguageCode());
		$languages = Language::getLanguages();
		$currentLanguage = Language::getCurrentLanguage();

		$englishInfinitive = $request->get("englishInfinitive");
		$englishConjugation = $request->get("englishConjugation");
		$foreignConjugation = $request->get("foreignConjugation");
		$speak = $request->get('speak');

		//dd($speak);

		return view('pages.verb', compact('currentLanguage', 'languageCode', 'languages', 'verb', 'tense', 'person',
			'englishInfinitive', 'englishConjugation', 'foreignConjugation', 'speak', 'loggedIn', 'errors'));
	}

	/**
	 * Retrieve a verb from the db table at random
	 */
	private function getVerb($id = null)
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
				->where("verbs.lang", "=", Session::get('languageCode', Language::getDefaultLanguageCode()))
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

		// Returning just the data in an array
		return (isset($verb[0]) ? $verb->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getTense($id = null)
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
				->where("tenses.lang", "=", Session::get('languageCode', Language::getDefaultLanguageCode()))
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

        // Returning just the data in an array
        return (isset($tense[0]) ? $tense->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getPerson($id = null)
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
				->where("persons.lang", "=", Session::get('languageCode', Language::getDefaultLanguageCode()))
				->orderBy(DB::raw('RAND()'))
				->limit(1)->get();
		}

        // Returning just the data in an array
        return (isset($person[0]) ? $person->toArray()[0]: null);
	}

}
