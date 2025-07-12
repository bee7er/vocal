<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Helpers\ImportVerb;
use App\Helpers\ImportAdverb;
use App\Helpers\ImportAdjective;

/**
 * Class ImportController
 * @package App\Http\Controllers
 */
class ImportController extends Controller
{
	const IMPORT_VERBS = 'verbs';
	const IMPORT_ADVERBS = 'adverbs';
	const IMPORT_ADJECTIVES = 'adjectives';
	const IMPORT_DATA_LOCATION = "/Users/brianetheridge/Code/vocal/database/import/";

	/**
	 * Import data according to type
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request, $fileName, $type, $languageCode, $clearTable)
	{
		$csvFileName = self::IMPORT_DATA_LOCATION . $fileName;

		switch ($type) {
			case self::IMPORT_VERBS:
				$importer = new ImportVerb();
				$importer->import($csvFileName, $languageCode, $clearTable);
				break;
			case self::IMPORT_ADVERBS:
				$importer = new ImportAdverb();
				$importer->import($csvFileName, $languageCode, $clearTable);
				break;
			case self::IMPORT_ADJECTIVES:
				$importer = new ImportAdjective();
				$importer->import($csvFileName, $languageCode, $clearTable);
				break;
		}
	}

}
