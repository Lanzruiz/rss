<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class SessionData extends Eloquent {
  protected $table = 'sessions';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
