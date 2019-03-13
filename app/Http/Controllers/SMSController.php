<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\SessionData;
    
use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Log;

class SMSController extends Controller
{
    protected $user_id;
    protected $security_code;
    protected $security_token;
    
    private function checkUserLogin() {
        
        $session_data = SessionData::find(Session::getId());
        if($session_data) {
            $data = unserialize(base64_decode($session_data->payload));
            
            $this->user_id = isset($data['users_id']) ? $data['users_id'] : 0;
            $this->security_code = isset($data['securityCode']) ? $data['securityCode'] : 0;
            $this->security_token = isset($data['securityToken']) ? $data['securityToken'] : 0;
            
            $users = Users::find(Session::get('users_id'));
            
            return $users;
        }
        
    }

    public function checkReplySMS($accesscode) {
      //this functionality is still on going
      require_once('public/sms/SmsInterface.inc.php');
      $si = new \SmsInterface(false, false);
      if($si->connect ("TBLTechNerds001", "y6DKNHZM", true, false)) {
          $srl = $si->checkReplies();
          Log::debug($srl);
        foreach($srl as $sr) {
          //echo $sr['phoneNumber'];
          //print_r($sr);die();

            //if ($sr->status == MessageStatus::delivered ()) {
                //save the message to database

                //get usersID
                $userID = $sr->messageID;
                //echo $userID;
                $users = Users::where('fldUserID','=',$userID)->first();
                //print_r($users);die();
                if(count($users) == 1) {
                  //get the smsreceive fields for the counter
                  $smsRecord = SMS::where('fldSMSUserID','=',$userID)
                                  ->orderBy('fldSMSID','DESC')
                                  ->first();

                  $receiveCount = count($smsRecord) == 1 ? $smsRecord->fldSMSReceive + 1 : 1;
                  $sendCount = count($smsRecord) == 1 ? $smsRecord->fldSMSMessageID : 1;

                  $message = $sr->message;

                  $sms = new SMS;
                      $sms->fldSMSUserID = $users->fldUserID;
                      $sms->fldSMSReceive = $receiveCount;
                      $sms->fldSMSPhone = $sr->phoneNumber;
                      $sms->fldSMSClientID = $users->fldUsersAccessCode;
                      $sms->fldSMSUserStatus = $users->fldUserSCStatus;
                      $sms->fldSMSContent = $message;
                      $sms->fldSMSDate = date('Y-m-d G:i:s');
                      $sms->fldSMSMessageID = $sendCount;
                      $sms->fldSMSType = 2;
                  $sms->save();
                }


            //}
        }
        //SMS::readSMS($si,$srl,Session::get('users_id'));

          $smsRecord = SMS::join('tblUser','tblUser.fldUserID','=','fldSMSUserID')
                      ->where('fldSMSClientID','=',$accesscode)
                      ->get();
          $response = '';
          foreach($smsRecord as $smsRecords) {
              $response .= '<div class="form-group" id="smsContentTO">';
              if($smsRecords->fldSMSType == 1) {
                $response .= '<div class="col-lg-12" align="right">';
                  $response .= '<div class="col-lg-7" style="background-color:#0C0; padding:6px; border-radius:5px;white-space:normal; float:right">'.$smsRecords->fldSMSContent.'<br>';
                    $response .= '<small>'.$smsRecords->fldSMSDate.'</small>';
                  $response .= '</div>';
                $response .= '</div>';
              } else {
                $response .= '<div class="col-lg-12" align="left">';
                  $response .= '<div class="col-lg-7" style="background-color:#d43f3a;color:#fff; padding:6px; border-radius:5px;white-space:normal; float:left">'.$smsRecords->fldSMSContent.'<br>';
                    $response .= '<small>'.$smsRecords->fldSMSDate.'</small>';
                  $response .= '</div>';
                $response .= '</div>';
              }
              $response .= '</div>';
          }

          echo $response;

      } else {
         echo "";
      }

    }

    public function displaySMS()
    {
     
        
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }





      $smsUser = SMS::join('tblUser','tblUser.fldUserID','=','fldSMSUserID')
                  ->groupBy('fldSMSUserID')
                  ->orderBy('fldSMSID','DESC')
                  ->where('fldUsersCommanderID','=',$this->user_id)
                  ->get();


       return View::make('dashboard.sms.index',compact('smsUser'));
    }

    public function displayReplySMS($accesscode) {
      
        
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }

      $smsUser = SMS::join('tblUser','tblUser.fldUserID','=','fldSMSUserID')
                  ->groupBy('fldSMSUserID')
                  ->orderBy('fldSMSID','DESC')
                  ->where('fldUsersCommanderID','=',$this->user_id)
                  ->get();


        $smsRecord = SMS::join('tblUser','tblUser.fldUserID','=','fldSMSUserID')
                    ->where('fldSMSClientID','=',$accesscode)
                    ->get();

       return View::make('dashboard.sms.reply',compact('smsUser','smsRecord','accesscode'));
    }

    public function sendSMS() {
      
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }

      $rules   = SMS::rules();
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
            return Redirect::to('/dashboard/sms')->withInput()->withErrors($validator,'sms');
      } else {
            $userType = Input::get('userType');
            $origMessage = Input::get('message');
            $userID = Input::get('userID');

            $user = Users::where('fldUserStatus','=',$userType)
                          ->where('fldUsersCommanderID','=',$this->user_id)
                          ->get();

            if(count($user) > 0) {
              if($userID == "all") {
                foreach($user as $users) {

                  $this->sendSMSByUsers($users,$origMessage);

                }
              } else {
                 $userInfo = Users::find($userID);
                 if(count($userInfo) == 1) {
                   $this->sendSMSByUsers($userInfo,$origMessage);
                 }
              }

                Session::flash('success','SMS was successfully sent.');


            }

            return Redirect::to('/dashboard/sms');
        }

    }

    private function sendSMSByUsers($users,$origMessage) {
      $content = 'Hi '.ucwords($users->fldUserLevel).' '.ucwords($users->fldUsersFullname).', ';
      $message = $content . $origMessage;

      $smsRec = SMS::where('fldSMSUserID','=',$users->fldUserID)
                    ->orderBy('fldSMSID','DESC')
                    ->first();
        $messageID = count($smsRec) == 1 ?  $smsRec->fldSMSMessageID + 1 : 1;

        $sms = new SMS;
            $sms->fldSMSUserID = $users->fldUserID;
            $sms->fldSMSMessageID = $messageID;
            $sms->fldSMSPhone = $users->fldUsersMobile;
            $sms->fldSMSClientID = $users->fldUsersAccessCode;
            $sms->fldSMSUserStatus = $users->fldUserSCStatus;
            $sms->fldSMSContent = $origMessage;
            $sms->fldSMSDate = date('Y-m-d G:i:s');
        $sms->save();

        //send sms
        SMS::sendSMS($users->fldUsersMobile,$message,$users->fldUserID);
    }


    public function sendReplySMS($accesscode) {
          if(!Session::has('users_id')) { return Redirect::to('/');}
          if(!Session::has('security_code')) { return Redirect::to('/');}

          $rules   = SMS::rulesReply();
          $validator = Validator::make(Input::all(), $rules);

          if ($validator->fails()) {
                return Redirect::to('/dashboard/reply/'.$accesscode)->withInput()->withErrors($validator,'sms');
          } else {

                  $origMessage = Input::get('message');

                  $smsRecord = SMS::join('tblUser','tblUser.fldUserID','=','fldSMSUserID')
                              ->where('fldSMSClientID','=',$accesscode)
                              ->orderBy('fldSMSID','DESC')
                              ->first();

                  if(count($smsRecord) == 1) {
                    $content = 'Hi '.ucwords($smsRecord->fldUserLevel).' '.ucwords($smsRecord->fldUsersFullname).', ';
                    $message = $content . $origMessage;

                      $messageID = count($smsRecord) == 1 ?  $smsRecord->fldSMSMessageID + 1 : 1;

                      $sms = new SMS;
                          $sms->fldSMSUserID = $smsRecord->fldUserID;
                          $sms->fldSMSMessageID = $messageID;
                          $sms->fldSMSPhone = $smsRecord->fldUsersMobile;
                          $sms->fldSMSClientID = $smsRecord->fldUsersAccessCode;
                          $sms->fldSMSUserStatus = $smsRecord->fldUserSCStatus;
                          $sms->fldSMSContent = $origMessage;
                          $sms->fldSMSDate = date('Y-m-d G:i:s');
                      $sms->save();

                      Log::debug("User Phone: " . $smsRecord->fldUsersMobile);
                      //send sms
                      SMS::sendSMS($smsRecord->fldUsersMobile,$message,$smsRecord->fldUserID);
                  }

                    Session::flash('success','SMS was successfully sent.');
                 return Redirect::to('/dashboard/reply/'.$accesscode);
            }

    }






}


class SmsReply {
	var	$phoneNumber;
	var	$message;
	var	$messageID;
	var	$when;
	var	$status;
	// Constructor.
	function SmsReply (
		$phoneNumber,
		$message,
		$messageID,
		$when,
		$status
	) {
		$this->phoneNumber = $phoneNumber;
		$this->message = $message;
		$this->messageID = $messageID;
		$this->when = $when;
		$this->status = $status;
	}
	// Unescape any escaped characters in the string.

  static function __set_state($arr) {
     return $arr;
  }

}
