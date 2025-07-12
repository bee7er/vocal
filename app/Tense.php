<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tense extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tense', 'english'];

}
