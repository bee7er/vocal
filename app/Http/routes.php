<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/verb', 'VerbController@index');
Route::get('/checkAnswers', 'VerbController@checkAnswers');
Route::post('/checkAnswers', 'VerbController@checkAnswers');
Route::get('/nextVerb', 'VerbController@nextVerb');
Route::post('/nextVerb', 'VerbController@nextVerb');
Route::get('/changeLanguage', 'VerbController@index');
Route::post('/changeLanguage', 'VerbController@changeLanguage');
/**
 * Import data in CSV format
 * Data to be located here:
 *
 *      /Users/brianetheridge/Code/vocal/database/import/
 *
 * Invocation example:
 *
 *      php artisan route:call --uri=/import/french_verbs.csv/verbs/fr/y
 *      php artisan route:call --uri=/import/italian_verbs.csv/verbs/it/n
 *
 *      php artisan route:call --uri=/import/french_adverbs.csv/adverbs/fr/y
 *      php artisan route:call --uri=/import/italian_adverbs.csv/adverbs/it/n
 *
 *      php artisan route:call --uri=/import/french_adjectives.csv/adjectives/fr/y
 *      php artisan route:call --uri=/import/italian_adjectives.csv/adjectives/it/n
 *
 */
Route::get('/import/{fileName}/{type}/{languageCode}/{clearTable}', 'ImportController@index');

