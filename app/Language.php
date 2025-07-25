<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Language extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'langs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['language', 'code', 'flag'];

    /**
     * Retrieve the default language code
     */
    public static function getDefaultLanguageCode()
    {
        return config('app.default_language_code');
    }

    /**
     * Retrieve supported languages
     */
    public static function getLanguages()
    {
        $langs = self::select(
            array(
                'langs.id',
                'langs.language',
                'langs.code',
                'langs.flag',
            )
        )
            ->orderBy("langs.language")
            ->limit(99)->get();

        return $langs;
    }

}