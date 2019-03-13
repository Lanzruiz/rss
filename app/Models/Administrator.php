<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class Administrator extends Eloquent
{
  protected $table = 'tblAdministrator';
  protected $primaryKey = 'fldAdministratorID';
  public $timestamps = false;

  public static function login() {
      $rules = [
              'username'        => 'required',
              'password'        => 'required',

          ];

       return $rules;
  }

  public static function rules() {
      $rules = [
              'email'        => 'required|email',
              'password'        => 'required',

          ];

       return $rules;
  }

  static function adminLogin() {
      $username = Input::get('username');
      $password = Input::get('password');
      $checkAccess = false;

      $adminRec = self::where('fldAdministratorEmail','=',$username)->first();

      if(count($adminRec) == 1) {
          $checkAccess = true;
      }


      if($checkAccess == true) {
          if (Hash::check($password, $adminRec->fldAdministratorPassword)) {
              Session::put('administratorID', $adminRec->fldAdministratorID);
          } else {
              $checkAccess = false;
          }
      }

      return $checkAccess;

  }


  static function CheckLogin() {
    $username = Input::get('email');
    $password = Input::get('password');
    $checkAccess = false;

    $adminRec = self::where('fldAdministratorEmail','=',$username)->first();

    if($adminRec) {
        $checkAccess = true;
    }


    if($checkAccess == true) {
        if (Hash::check($password, $adminRec->fldAdministratorPassword)) {
            Session::put('administrator_id', $adminRec->fldAdministratorID);
        } else {
            $checkAccess = false;
        }
    }

    return $checkAccess;

  }


  static function SaveUpdateAdministrator($id) {
      if($id == 0) {
         $admin = new self;
      } else {
         $admin = self::find($id);
      }

      $admin->fldAdministratorEmail = Input::get('email');
      $admin->fldAdministratorName = Input::get('name');
      $admin->fldAdministratorContactNo = Input::get('contact_no');
      $password = Input::get('password');
      if($password != "") {
         $admin->fldAdministratorPassword = Hash::make(Input::get('password'));

      }
      $admin->save();
  }



}
