<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class TenseDetailController
 * @package App\Http\Controllers
 */
class TenseDetailController extends Controller
{
	/**
	 * Create a new instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
	}

	/**
	 * Return the requested tense detail pdf
	 */
	public function getTenseDetails(Request $request)
	{
		return response()->json([
			'success' => 1,
			'data' => $request->get('pdf'),
		]);
	}

}
