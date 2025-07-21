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
/* Work with Verbs */
Route::post('/admin', 'Admin\AdminController@index');
Route::get('/workWithVerbs/{lang}/{pos}/{fil}', 'Admin\AdminVerbController@backToWork');
Route::get('/workWithVerbs/{lang}/{pos}', 'Admin\AdminVerbController@backToWork');
Route::get('/workWithVerbs/{lang}', 'Admin\AdminVerbController@backToWork');
Route::post('/workWithVerbs', 'Admin\AdminVerbController@index');
Route::post('/addVerb', 'Admin\AdminVerbController@addVerb');
Route::post('/editVerb', 'Admin\AdminVerbController@editVerb');
Route::post('/updateVerb', 'Admin\AdminVerbController@updateVerb');
Route::post('/deleteVerb', 'Admin\AdminVerbController@deleteVerb');
/* Work with Adverbs */
Route::post('/workWithAdverbs', 'Admin\AdminAdverbController@index');
Route::get('/workWithAdverbs/{lang}/{pos}/{fil}', 'Admin\AdminAdverbController@backToWork');
Route::get('/workWithAdverbs/{lang}/{pos}', 'Admin\AdminAdverbController@backToWork');
Route::get('/workWithAdverbs/{lang}', 'Admin\AdminAdverbController@backToWork');
Route::post('/addAdverb', 'Admin\AdminAdverbController@addAdverb');
Route::post('/editAdverb', 'Admin\AdminAdverbController@editAdverb');
Route::post('/updateAdverb', 'Admin\AdminAdverbController@updateAdverb');
Route::post('/deleteAdverb', 'Admin\AdminAdverbController@deleteAdverb');
/* Work with Adjectives */
Route::post('/workWithAdjectives', 'Admin\AdminAdjectiveController@index');
Route::get('/workWithAdjectives/{lang}/{pos}/{fil}', 'Admin\AdminAdjectiveController@backToWork');
Route::get('/workWithAdjectives/{lang}/{pos}', 'Admin\AdminAdjectiveController@backToWork');
Route::get('/workWithAdjectives/{lang}', 'Admin\AdminAdjectiveController@backToWork');
Route::post('/addAdjective', 'Admin\AdminAdjectiveController@addAdjective');
Route::post('/editAdjective', 'Admin\AdminAdjectiveController@editAdjective');
Route::post('/updateAdjective', 'Admin\AdminAdjectiveController@updateAdjective');
Route::post('/deleteAdjective', 'Admin\AdminAdjectiveController@deleteAdjective');
/* Change the currently selected language */
Route::post('/changeLanguage', 'LanguageController@changeLanguage');

Route::get('/getInfo', 'LanguageController@getInfo');

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

