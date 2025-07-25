<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adverb extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'adverbs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['adverb', 'english', 'lang'];

}
