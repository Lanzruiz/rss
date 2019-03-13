<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class Country extends Eloquent
{
    protected $table = 'country';
    protected $primaryKey = 'id';
    public $timestamps = false;

    static public function DisplayCountry() {
        $country = self::orderBy('name')
                      ->get();
        return $country;
    }

    
}
