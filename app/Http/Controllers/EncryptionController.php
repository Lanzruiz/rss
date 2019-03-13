<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\Administrator;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Crypt;

class EncryptionController extends Controller
{
    public function TestEncryption()
    {
       $testValue = "123456";
       $encrypted = Crypt::encrypt($testValue);
       echo "Ecrypted: " . $encrypted;

       try {
            $decrypted = Crypt::decrypt($encrypted);
            echo "<br>Decrypted: " . $decrypted;
        } catch (DecryptException $e) {
          print_r($e);
        }

    }



}
