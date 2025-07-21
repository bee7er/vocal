<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenseDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tense_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tense_id', 'language_id', 'details'];

}
