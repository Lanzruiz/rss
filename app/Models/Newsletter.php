<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class Newsletter extends Eloquent
{
  protected $table = 'tblNewsletter';
  protected $primaryKey = 'fldNewsletterID';
  public $timestamps = false;

  public static function rules() {


            $rules = [

                'name'        => 'required',
                'description'         => 'required'

            ];



        return $rules;
    }


  public static function AddUpdateNewsletter($id) {
      if($id == 0) {
        $newsletter = new self;
      } else {
        $newsletter = self::find($id);
      }

      $newsletter->fldNewsletterName = Input::get('name');
      $newsletter->fldNewsletterDescription = Input::get('description');
      $newsletter->save();

  }

}
