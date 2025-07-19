<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verb extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'verbs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['infinitive', 'reflexive', 'english', 'lang'];

}
