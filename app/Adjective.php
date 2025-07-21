<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjective extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'adjectives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['adjective', 'english', 'lang'];

}
