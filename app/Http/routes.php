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
Route::post('/home', 'HomeController@index');
Route::post('/verb', 'VerbController@index');
Route::get('/checkAnswers', 'VerbController@checkAnswers');
Route::post('/checkAnswers', 'VerbController@checkAnswers');
Route::get('/nextVerb', 'VerbController@nextVerb');
Route::post('/nextVerb', 'VerbController@nextVerb');
Route::post('/adverb', 'AdverbController@index');
Route::get('/checkAdverbAnswers', 'AdverbController@checkAnswers');
Route::post('/checkAdverbAnswers', 'AdverbController@checkAnswers');
Route::get('/nextAdverb', 'AdverbController@nextAdverb');
Route::post('/nextAdverb', 'AdverbController@nextAdverb');
Route::post('/adjective', 'AdjectiveController@index');
Route::get('/checkAdjectiveAnswers', 'AdjectiveController@checkAnswers');
Route::post('/checkAdjectiveAnswers', 'AdjectiveController@checkAnswers');
Route::get('/nextAdjective', 'AdjectiveController@nextAdjective');
Route::post('/nextAdjective', 'AdjectiveController@nextAdjective');

Route::post('/admin', 'Admin\AdminController@index');
Route::post('/workWithVerbs', 'Admin\AdminVerbController@index');
Route::post('/workWithVerbs/{pos}', 'Admin\AdminVerbController@index');
Route::get('/workWithVerbs/{pos}', 'Admin\AdminVerbController@index');
Route::post('/workWithAdverbs', 'Admin\AdminAdverbController@index');
Route::post('/workWithAdjectives', 'Admin\AdminAdjectiveController@index');
Route::post('/addVerb', 'Admin\AdminVerbController@addVerb');
Route::post('/editVerb', 'Admin\AdminVerbController@editVerb');
Route::post('/updateVerb', 'Admin\AdminVerbController@updateVerb');
Route::post('/deleteVerb', 'Admin\AdminVerbController@deleteVerb');

Route::post('/changeLanguage', 'LanguageController@changeLanguage');
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

