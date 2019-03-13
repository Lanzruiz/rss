<?php

namespace App\Models;
use App\Models\Users;
use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;
use Mail;

class SMS extends Eloquent
{
  protected $table = 'tblSMS';
  protected $primaryKey = 'fldSMSID';
  public $timestamps = false;

      public static function rules() {
          $rules = [
                  'userType'        => 'required',
                  'message'        => 'required',
              ];

           return $rules;
      }

      public static function rulesReply() {
          $rules = [
                  'message'        => 'required',
              ];

           return $rules;
      }

    public static function sendSMS($phone,$message,$client_id) {

       require_once('public/sms/SmsInterface.inc.php');

       $selection = "0123456789";
       $arr = str_split($phone);
       $len = count($arr);
        $count = -1;
        $output = "";
        while(++$count < $len){
        	$selected = $arr[$count];
        	if(strpos($selection, $selected) !== false)
        		$output .= $selected;
        }
        $phone = $output;
        if((strlen($phone) <= 10) && (substr($phone,0,1) != "1"))
        //$phone = "1".$phone;
        Log::debug("Phone Display: " . $phone);
        $message_received = $smsmsg = isset($message) ? $message : '0';
        //$command_word=substr($smsmsg,0,8);
        //$message_received = trim(str_replace(PRODUCT_TITLE, "", strtolower($smsmsg)));
        //$message_received = trim(str_replace(PRODUCT_TITLE, "", strtolower($message_received)));
        //only furst line is needed. beyond that might be a signature.
        // if (($crloc = strpos($message_received,"\n")) > 0) {
        // 	$message_received = substr($message_received,0,$crloc-1);
        // }
        $response = $smsmsg;
        Log::debug("Message: " . $response);
        $si = new \SmsInterface (false, false);
        $si->addMessage ("+".$phone, $response, $client_id);
        $response = $response .  " SMS SEND RESULTS: ";
        Log::debug($response);
        if(!$si->connect ("TBLTechNerds001", "y6DKNHZM", true, false)){
        	$response = $response . "failed. Could not contact server.";
          Log::debug($response);
        }elseif (!$si->sendMessages ()){
        	$response = $response . "failed. Could not send message to server.";
          Log::debug($response);
        	if($si->getResponseMessage () !== NULL){
        		$response = $response . " Reason: " . $si->getResponseMessage ();
            Log::debug($response);
        	}
        }else{
        	$response = $response . "OK.";
          Log::debug($response);
        }


    }


    public static function readSMS($si,$srl, $client_id) {



      if (!$si->connect ('TBLTechNerds001', 'y6DKNHZM', true, false)){
        Log::debug('Unable to connect to the SMS server');
      } elseif (($srl) === NULL) {
        Log::debug('Unable to read messages from the SMS server.');
      	if ($si->getResponseMessage () !== NULL){
          Log::debug('Reason:'.$si->getResponseMessage());
      	}
      } elseif (count ($srl) == 0){
        Log::debug('No unread message(s) found.');
      } else {
      	foreach ($srl as $sr) {
      		if(substr($sr->messageID,0,6) != $client_id){
      			//echo $client_id;
      			return;
      		} else {
      			if ($sr->status == MessageStatus::none ()) {
      				//$messageID = substr($sr->messageID,7);
      				//mysqli_query($con,"insert into sms set messageID = ".$messageID.", userPhoneNumber = '".$sr->phoneNumber."', clientID = ".substr($sr->messageID,1,6).", smsReply = '".$sr->message."', userStatus = ".substr($sr->messageID,0,1));
      				//echo "messages: ".$sr->message;
              Log::debug('Message None');
      			} elseif ($sr->status == MessageStatus::pending ()) {
              Log::debug('Message delivery pending');
      			} elseif ($sr->status == MessageStatus::delivered ()) {
              Log::debug('Message successfully delivered');
      			} else {
              Log::debug('Message delivery failed');
      			}
      		}
      	}
    }
  }


    public static function countSMS($userID) {
          $users = self::where('fldSMSUserID','=',$userID)
                       ->orderBy('fldSMSID','DESC')
                       ->first();
          echo $users->fldSMSMessageID;
    }

    public static function countReplySMS($userID) {
          $users = self::where('fldSMSUserID','=',$userID)
                       ->orderBy('fldSMSID','DESC')
                       ->first();
          echo $users->fldSMSReceive == "" ? 0 : $users->fldSMSReceive;
    }



   public static function StartFeedsSMS($user) {
      //check if user is transport or agent
      //* when transport start feeds and start video, corresponding agents and commanders will get sms
      //* when agent will start feeds, only commander will get sms
      //not all commanders and not all agent, only corresponding will get

      //send sms to commander


      $commander = Users::find($user->fldUsersCommanderID);
      if(count($commander) > 0) {
          if($user->fldUserLevel == "transport") {
              $message = "Hi Commander ".$commander->fldUsersFullname.", ".$user->fldUsersFullname." is underway.";
              $subject = $user->fldUsersFullname . " is underway.";
          } else {
              $message = "Hi Commander ".$commander->fldUsersFullname.", ".$user->fldUsersFullname." is in service.";
              $subject = $user->fldUsersFullname . " is in service.";
          }

          Log::debug("Send SMS to Commander " . $commander->fldUsersFullname);
          Log::debug("Command Message " . $message);
          self::sendEmail($commander,$message,$subject);
          $areaCode = $commander->fldUserCountryCode;
          self::sendSMS($areaCode.$commander->fldUsersMobile,$message,$commander->fldUserID);
      }

      if($user->fldUserLevel == "transport") {
              Log::debug("Send SMS to Agent " . $user->fldUsersFullname);
            $userAgent = Users::where('fldUsersCommanderID','=',$user->fldUsersCommanderID)
                              //->where('fldUsersTransportID','=',$user->fldUserID)
                              ->where('fldUserLevel','=','agent')
                              ->get();


            //send sms to agent
            foreach($userAgent as $userAgents) {
              $message = "Hi Agent " .$userAgents->fldUsersFullname.", ".$user->fldUsersFullname." is underway.";
              Log::debug("Agent Message " . $message);
              $subject = $user->fldUsersFullname . " is underway.";
              self::sendEmail($userAgents,$message,$subject);
               $areaCode = $commander->fldUserCountryCode;
              self::sendSMS($areaCode.$userAgents->fldUsersMobile,$message,$userAgents->fldUserID);
            }

      }
   }


   public static function StopFeedsSMS($user) {

      //send sms to commander
      $commander = Users::find($user->fldUsersCommanderID);
      if(count($commander) > 0) {
          if($user->fldUserLevel == "transport") {
              $message = "Hi Commander ".$commander->fldUsersFullname.", ".$user->fldUsersFullname." has ended.";
              $subject = $user->fldUsersFullname . " has ended.";
          } else {
              $message = "Hi Commander ".$commander->fldUsersFullname.", ".$user->fldUsersFullname." is off-service.";
              $subject = $user->fldUsersFullname . " is off-service.";
          }

          Log::debug("STOP Send SMS to Commander " . $commander->fldUsersFullname);
          Log::debug("STOP Command Message " . $message);
          self::sendEmail($commander,$message,$subject);
          $areaCode = $commander->fldUserCountryCode;
          self::sendSMS($areaCode.$commander->fldUsersMobile,$message,$commander->fldUserID);
      }

      if($user->fldUserLevel == "transport") {
              Log::debug("STOP Send SMS to Agent " . $user->fldUsersFullname);
            $userAgent = Users::where('fldUsersCommanderID','=',$user->fldUsersCommanderID)
                              //->where('fldUsersTransportID','=',$user->fldUserID)
                              ->where('fldUserLevel','=','agent')
                              ->get();


            //send sms to agent
            foreach($userAgent as $userAgents) {
              $message = "Hi Agent ".$userAgents->fldUsersFullname.", ".$user->fldUsersFullname." has ended.";
              $subject = $user->fldUsersFullname . " has ended.";
              Log::debug("STOP Agent Message " . $message);
              self::sendEmail($userAgents,$message,$subject);
              $areaCode = $userAgents->fldUserCountryCode;
              self::sendSMS($areaCode.$userAgents->fldUsersMobile,$message,$userAgents->fldUserID);
            }

      }
   }

   public static function sendEmail($user,$message,$subject) {
     // $to = $user->fldUsersEmail;
     // Log::debug("Email  ".$to);
     // $subject = PRODUCT_TITLE." ".$subject;
     // $txt = "<html><body>";
     // $txt .= "<div style='width: 100%; background-color:#070f71; padding:5px;'>";
     // $txt .= "<img src='{{url('public/assets/images/main-logo.png')}}' width='200px'>";
     // $txt .= "</div>";
     // $txt .= "<p>".$message."</p>";
     // $txt .= "</body></html>";
     // Log::debug("Email Sent ".$txt);
     // $headers = "MIME-Version: 1.0" . "\r\n";
     // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";    // Always set content-type when sending HTML email
     // $headers .= 'From: '.PRODUCT_TITLE.'<info@livewitnessapp.net>' . "\r\n";
     // $headers .= 'Bcc: <'.BCC.'>';
     // mail($to,$subject,$txt,$headers);

         $memberData = array('messages'=>$message);
         $to = $user->fldUsersEmail;
         $toName = $user->fldUsersFullname;
         Mail::send('dashboard.emails.email', $memberData, function ($message) use ($to,$toName,$subject) {

             $message->from("info@0321technologies.com",PRODUCT_TITLE);
             $message->to($to,$toName)->subject(PRODUCT_TITLE." ".$subject);
             $message->bcc(BCC);
         });


   }





}
