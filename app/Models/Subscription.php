<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class Subscription extends Eloquent
{
  protected $table = 'subscription';
  protected $primaryKey = 'id';
  public $timestamps = false;


}
