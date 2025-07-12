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
		$loggedIn = false;
		if ($this->auth->check()) {
			$loggedIn = true;
		}

        $languageCode = Session::get('languageCode', $this->getDefaultLanguageCode());
		$languages = Language::getLanguages();
        $currentLanguage = Language::getCurrentLanguage();

		$verb = $this->getVerb();
		$tense = $this->getTense();
		$person = $this->getPerson();

		return view('pages.verb', compact('currentLanguage', 'languageCode', 'languages', 'verb', 'tense', 'person', 'loggedIn'));
	}

	/**
	 * Present a verb
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function nextVerb(Request $request)
	{
        // Validate response to the verb, tense and person combination

		return $this->index($request);
	}

	/**
	 * Retrieve a verb from the db table at random
	 */
	private function getVerb()
	{
		$verb = Verb::select(
			array(
				'verbs.id',
				'verbs.infinitive',
				'verbs.english',
				'verbs.reflexive',
				'verbs.lang',
			)
		)
			->where("verbs.lang", "=", Session::get('languageCode'))
            ->orderBy(DB::raw('RAND()'))
			->limit(1)->get();

		// Returning just the data in an array
        return (isset($verb[0]) ? $verb->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getTense()
	{
		$tense = Tense::select(
			array(
				'tenses.id',
				'tenses.tense',
				'tenses.english',
				'tenses.lang',
			)
		)
            ->where("tenses.lang", "=", Session::get('languageCode'))
            ->orderBy(DB::raw('RAND()'))
			->limit(1)->get();

        // Returning just the data in an array
        return (isset($tense[0]) ? $tense->toArray()[0]: null);
	}

	/**
	 * Retrieve a tense from the db table at random
	 */
	private function getPerson()
	{
		$person = Person::select(
			array(
				'persons.id',
				'persons.person',
				'persons.english',
				'persons.lang',
			)
		)
            ->where("persons.lang", "=", Session::get('languageCode'))
            ->orderBy(DB::raw('RAND()'))
			->limit(1)->get();

        // Returning just the data in an array
        return (isset($person[0]) ? $person->toArray()[0]: null);
	}

}
