<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
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
	 * Show the application dashboard to the user.
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

		$languageCode = Session::get('languageCode', Language::getDefaultLanguageCode());
		$languages = Language::getLanguages();

		return view('pages.home', compact('languageCode', 'languages', 'loggedIn'));
	}

}
