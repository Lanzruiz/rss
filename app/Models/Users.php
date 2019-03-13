<?php

namespace App\Models;
use App\Models\SMS;
use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;
use Mail;

class Users extends Eloquent
{
    protected $table = 'tblUser';
    protected $primaryKey = 'fldUserID';
    public $timestamps = false;


    public static function rules($id) {

        if($id == 0) {
            $rules = [
                'username'        => 'required|max:255|unique:tblUser,fldUsersUserName',
                'fullname'         => 'required|max:255',
                'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
                'password'         => 'required|min:6|max:12',
                'email'            => 'required|email'
                //'email'            => 'required|email|unique:tblUser,fldUsersEmail'
                // 'password'         => 'required|min:8|regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X]).*$/'
            ];
        } else {
            $rules = [

                'fullname'         => 'required|max:255',
                'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
                'email'            => 'required|email'
                //'email'            => 'required|email|unique:tblUser,fldUsersEmail,'.$id.',fldUserID'
               // 'password'         => 'min:8|regex:/^.*(?=.{1,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X]).*$/'

            ];
        }


        return $rules;
    }

    public static function login() {
        $rules = [
                'username'        => 'required',
                'password'        => 'required',

            ];

         return $rules;
    }

    public static function rulesUser($id) {
        if($id == 0) {
            $rules = [
                'fullname'         => 'required|max:255',
                'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
                'email'            => 'required|email',
                'userType'       => 'required'
                //'email'            => 'required|email|unique:tblUser,fldUsersEmail'
                ];
        } else {
            $rules = [

                'fullname'         => 'required|max:255',
                'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
                'email'            => 'required|email',
                'userType'       => 'required'
                //'email'            => 'required|email|unique:tblUser,fldUsersEmail,'.$id.',fldUserID'

            ];
        }


        return $rules;
    }

    public static function rulesUserAgent($id) {
      if($id == 0) {
          $rules = [
              'fullname'         => 'required|max:255',
              'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
              'email'            => 'required|email',
              'userType'       => 'required',
              //'transportID'    => 'required'
              //'email'            => 'required|email|unique:tblUser,fldUsersEmail'
              ];
      } else {
          $rules = [

              'fullname'         => 'required|max:255',
              'mobile'         => 'required', // |max:15|min:10 10-01-2018 removed mobile number limit by Michael Reyes
              'email'            => 'required|email',
              'userType'       => 'required',
              //'transportID'    => 'required'
              //'email'            => 'required|email|unique:tblUser,fldUsersEmail,'.$id.',fldUserID'

          ];
      }


      return $rules;
    }


    static function AddUpdateUser($id) {



        if($id == 0) {
            $user = new self;
                   $is_unique = false;
                    $num = false;
                    while (!$is_unique){
                        $num = rand(100000,999999);
                        $accessCheck = self::checkAccessCode($num);
                        if($accessCheck == 0) {
                            $is_unique = true;
                        }
                    }

                  $user->fldUsersAccessCode = $num;

                  $security_code = rand(100000,999999);
                  $user->fldUserSecurityCode = $security_code;

                  $user->fldUsersUserName = Input::get('username');
                  $user->fldUserLevel = "commander";
                  $user->fldUserStatus = "2";
                  //temporary turn off the security_code
                  $user->fldUserSCStatus = 0;
        } else {
            $user = self::find($id);

                $user->fldUserSCStatus = Input::get('scOnOffStatus');
        }

        //echo Input::get('country_code');die();

        $user->fldUsersFullname = Input::get('fullname');
        $user->fldUsersEmail = Input::get('email');
        $user->fldUsersMobile = Input::get('mobile');
        $user->fldUserCountryID = Input::get('country_code');
        $country = Country::find(Input::get('country_code'));
        if(count($country) == 1) {
          $user->fldUserCountryCode = '+'.$country->phonecode;
        }



        if(Input::get('password') != "") {
             $password = Hash::make(Input::get('password'));
             $user->fldUsersPassword = $password;

        }



        $user->save();

         if($id == 0) {


           //send SMS to user
          // $message = "Hi ".Input::get('fullname').", Your activation code is ".$num.". Please go to http://livewitnessapp.net/dllp and install the app";
           //SMS::sendSMS(Input::get('mobile'),$message,$user->fldUserID);

            // $txt = "<html><body>";
            // $txt .= "<div style='width: 100%; background-color:#070f71; padding:5px;'>";
            // $txt .= "<img src='{{url('public/assets/images/main-logo.png')}}' width='200px'>";
            // $txt .= "</div>";
            // $txt .= "<p>Dear ".ucwords(Input::get('fullname'))."</p>";
            // $txt .= "<p>Thank you for registering your Commander account with ".PRODUCT_TITLE.".</p>";
            // $txt .= "<p><table><tr><td>Your Username is</td><td>:</td><td>".Input::get('username')."</td></tr>";
            // $txt .= "<tr><td>Your Password is</td><td>:</td><td>".Input::get('password')."</td></tr></table>";
            // $txt .= "<br> To login, please click here: <a href='https://livewitnessapp.net/'>".PRODUCT_TITLE."</a></p>";
            // $txt .= "<p>Please keep this information secure, as it is required to access the ".PRODUCT_TITLE." Command Center.</p>";
            // //$txt .= "<p>Any questions, please email client support services here: info@livewitnessapp.net</p>";
            // $txt .= "<p>Any questions, please email client support services here: info@livewitnessapp.net</p>";
            // $txt .= "<p style='background-color:#CCC; text-align:left; padding:5px; border:1px solid #999'>NOTICE: This email and any attachments contain confidential information intended only for the individual(s) named above. You are strictly prohibited from any unauthorized use, disclosure, distribution, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email. If you have received this email in error, please notify the sender immediately and delete/destroy any and all copies of the original message. If you are not the intended recipient you are further notified that disclosing, copying, distributing, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email or taking any action in reliance upon the contents of this information is strictly prohibited.</p>";
            // $txt .= "</body></html>";
            // //email sending service
            // $to = Input::get('email');
            // $subject = PRODUCT_TITLE." Commander Registration Accepted";
            // // Always set content-type when sending HTML email
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // $headers .= 'From: '.PRODUCT_TITLE.'<info@livewitnessapp.net>' . "\r\n";
            // $headers .= 'Bcc: <'.BCC.'>';
            // mail($to,$subject,$txt,$headers);

          $message = "Thank you for registering your account with ".PRODUCT_TITLE." Your Username is: ".Input::get('username')." Your Password is: ".Input::get('password');
            SMS::sendSMS('+'.$country->phonecode.Input::get('mobile'),$message,$user->fldUserID);

            $memberData = array('fullname'=>Input::get('fullname'),'username'=>Input::get('username'),'password'=>Input::get('password'));
            $to = Input::get('email');
            $toName = Input::get('fullname');

            Mail::send('dashboard.emails.commander', $memberData, function ($message) use ($to,$toName) {

                $message->from("info@0321technologies.com",PRODUCT_TITLE);
                $message->to($to,$toName)->subject(PRODUCT_TITLE." Commander Registration Accepted");
                $message->bcc(BCC);
            });


             //add agent
             self::addAgentTransport(1,$user->fldUserID);

             //add transport
             self::addAgentTransport(0,$user->fldUserID);

            //send mail
            // Mail::send('email.commander', $user, function ($message) use($user) {
            //     $message->from(Input::get('email'), Input::get('firstname') . ' ' . Input::get('lastname'));
            //     $message->to($email, $fullname)->subject("Contact Us");
            // });
        }

        return $user;

    }


    private static function addAgentTransport($type,$commander_id) {
        $user = new self;

        $is_unique = false;
        $num = false;
        while (!$is_unique){
            $num = rand(100000,999999);
            $accessCheck = self::checkAccessCode($num);
            if($accessCheck == 0) {
                $is_unique = true;
            }
        }

        $user->fldUsersAccessCode = $num;
        $user->fldUsersCommanderID = $commander_id;

        //get commander information
        $commander = Users::find($commander_id);
        if(!$commander) {
            return Redirect::to('/');
        }


        $userType = $type;
        $type_name = $type == 1 ? "agent" : "transport";
        $username = $type_name.rand(1111,9999);
        $user->fldUsersFullname = Input::get('fullname');
        $user->fldUsersEmail = Input::get('email');
        $user->fldUsersUserName = $username;
        $user->fldUsersMobile = Input::get('mobile');

        $password = Input::get('password');
        if($password != "") {
            $user->fldUsersPassword = Hash::make($password);
            $user->fldUsersPasswordTxt = $password;
        }

        $user->fldUserCountryID = Input::get('country_code');
        $country = Country::find(Input::get('country_code'));
        if($country) {
            $user->fldUserCountryCode = '+'.$country->phonecode;
        }

        $user->fldUsersTransportID =  0;
        $user->fldUserStatus = $userType;
        if($userType == 1) {
            $userLevel = 'agent';
        } else if($userType == 0) {
            $userLevel = 'transport';
        }
        $user->fldUserLevel = $userLevel;
        $user->save();



        $message = "Hi ".Input::get('fullname').", Your activation code is ".$num.". Please go to https://raptorsecuritysoftware.com/ and install the app";


        //Log::debug('Phone no: +'.$country->phonecode.Input::get('mobile'));
        SMS::sendSMS("+".$country->phonecode.Input::get('mobile'),$message,$user->fldUserID);

        $memberData = array("commander"=>$commander,"user"=>$user,'fullname'=>Input::get('fullname'),'userLevel'=>strtoupper($userLevel),'password'=>$password,'username'=>$username);
        $to = Input::get('email');
        $toName = Input::get('fullname');
        Mail::send('dashboard.emails.users', $memberData, function ($message) use ($to,$toName) {
                   $message->from("info@raptorsecuritysoftware.com",PRODUCT_TITLE);
                   $message->to($to,$toName)->subject(PRODUCT_TITLE." Account Registration Confirmation");
                   $message->bcc(BCC);
                   });


    }


    static function checkAccessCode($accesscode) {
        $user = self::where('fldUsersAccessCode','=',$accesscode)->count();
        return $user;
    }


    static function userLogin() {
        $username = Input::get('username');
        $password = Input::get('password');
        $checkAccess = false;

        $userRec = self::where('fldUsersEmail','=',$username)->first();
        if(count($userRec) == 0) {
            //check username
            $userRec = self::where('fldUsersUserName','=',$username)->first();
            if(count($userRec) == 1) {
               $checkAccess = true;
            }
        } else {
            $checkAccess = true;
        }


        if($checkAccess == true) {
            if (Hash::check($password, $userRec->fldUsersPassword)) {
                Session::put('users_id', $userRec->fldUserID);
                Session::put('securityCode', $userRec->fldUsersAccessCode);

                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $token = substr(str_shuffle(str_repeat($pool, 55)), 0, 55);
                  Session::put('securityToken', $token);
                  $userRec->fldUserAPIToken = $token;
                  $userRec->save();

                Session::save();

            } else {
                $checkAccess = false;
            }
        }

        return $checkAccess;

    }

    static function checkSecurityCode() {
        $code = Input::get('security_code');
        $status = Input::get('scOnOffStatus');
        $userID = Session::get('users_id');

        $user = self::where('fldUserSecurityCode','=',$code)
                    ->where('fldUserID','=',$userID)
                    ->first();

        if(count($user)==1) {
            // /mysqli_query($con,"update User set security_code = 1, sc_status = $scStatus where user_id = $UserID");

            $user = self::find($userID);
                $user->fldUserSCStatus = $status;
                //$user->fldUserSecurityCode = 1;
            $user->save();

            Session::put('security_code', $code);

            return true;
        }  else {
            return false;
        }



    }


    static function AddDashboardUser($id) {
        if($id == 0) {
            $user = new self;
                   $is_unique = false;
                    $num = false;
                    while (!$is_unique){
                        $num = rand(100000,999999);
                        $accessCheck = self::checkAccessCode($num);
                        if($accessCheck == 0) {
                            $is_unique = true;
                        }
                    }

                  $user->fldUsersAccessCode = $num;

                  $user->fldUsersCommanderID = Session::get('users_id');

                  //get commander information
                  $commander = Users::find(Session::get('users_id'));

                  if(count($commander) == 0) {
                      return Redirect::to('/');
                  }

        } else {
            $user = self::find($id);

            //refresh transportid that on agent
            $userAgentSearch = Users::where('fldUsersTransportID','=',$user->fldUserID)
                                    ->get();
            foreach($userAgentSearch as $userAgentSearchs) {
                $userAgentSearchs->fldUsersTransportID = 0;
                $userAgentSearchs->save();
            }


        }




        $userType = Input::get('userType');

        $user->fldUsersFullname = Input::get('fullname');
        $user->fldUsersEmail = Input::get('email');
        $user->fldUsersUserName = Input::get('username');
        //$user->fldUsersMobile = Input::get('mobile');
        $user->fldUsersMobile = Input::get('mobile');

        $password = Input::get('password');
        if($password != "") {
          $user->fldUsersPassword = Hash::make($password);
          $user->fldUsersPasswordTxt = $password;
        }

        $user->fldUserCountryID = Input::get('country_code');
        $country = Country::find(Input::get('country_code'));
        if(count($country) == 1) {
          $user->fldUserCountryCode = '+'.$country->phonecode;
        }

        $user->fldUsersTransportID = Input::get('transportID') ? Input::get('transportID') : 0;
        $user->fldUserStatus = $userType;
        if($userType == 1) {
            $userLevel = 'agent';
        } else if($userType == 0) {
            $userLevel = 'transport';



        }
        $user->fldUserLevel = $userLevel;

        $user->save();

        if($userType == 0) {


          //update the agent id
            $agent = Input::get('agentID');
            if(count($agent) > 0) {
                  foreach($agent as $agents) {
                      $userAgent = Users::find($agents);
                      if(count($userAgent) == 1) {
                         $userAgent->fldUsersTransportID = $user->fldUserID;
                         $userAgent->save();
                      }
                  }
           }
        }



        if($id == 0) {

          //send SMS to user
          $message = "Hi ".Input::get('fullname').", Your activation code is ".$num.". Please go to https://raptorsecuritysoftware.com/ and install the app";

          $message .= "\n Your username is: ". $user->fldUsersUserName . "and your Password is: ". $password;


          //Log::debug('Phone no: +'.$country->phonecode.Input::get('mobile'));
          SMS::sendSMS("+".$country->phonecode.Input::get('mobile'),$message,$user->fldUserID);

          $memberData = array("commander"=>$commander,"user"=>$user,'fullname'=>Input::get('fullname'),'userLevel'=>strtoupper($userLevel),'password'=>$password,'username'=>Input::get('username'));
          $to = Input::get('email');
          $toName = Input::get('fullname');
          Mail::send('dashboard.emails.users', $memberData, function ($message) use ($to,$toName) {

              $message->from("info@raptorsecuritysoftware.com",PRODUCT_TITLE);
              $message->to($to,$toName)->subject(PRODUCT_TITLE." Account Registration Confirmation");
              $message->bcc(BCC);
          });

            // $to = Input::get('email');
            // $subject = PRODUCT_TITLE." Account Registration Confirmation";
            // $txt = "<html><body>";
            // $txt .= "<div style='width: 100%; background-color:#070f71; padding:5px;'>";
            // $txt .= "<img src='{{url('public/assets/images/main-logo.png')}}' width='200px'>";
            // $txt .= "</div>";
            // $txt .= "<p>Dear ".ucwords(Input::get('fullname'))."</p>";
            // $txt .= "<p>Commander ".$commander->fldUsersFullname." has registered an account for you as ".strtoupper($userLevel)." at ".PRODUCT_TITLE.". You will receive a text message shortly with your activation code to download and install the ".PRODUCT_TITLE." app directly from your phone. Simply follow the instructions to install and use ".PRODUCT_TITLE.".</p>";
            // $txt .= "<p>Here is the contact information that was provided by Commander ".$commander->fldUsersFullname.":</p>";
            // $txt .= "• Name: ".$commander->fldUsersUserName."<br>• Mobile Number: ".$commander->fldUsersMobile."<br>• Email Address: ".$commander->fldUsersEmail;
            // $txt .= "<p>NOTE: If any part of your contact information is incorrect, please contact Commander ".$commander->fldUsersFullname." @ ".$commander->fldUsersEmail."</p>";
            // $txt .= "<p>Please retain the below authorized user credentials for your records:</p>";
            // $txt .= "<p>Your activation code is: ".$user->fldUsersAccessCode." </p>";
            // $txt .= "<p> App installation link: <a href='{{url('dllp')}}'>Download</a> and install the app</p>";
            // //$txt .= "<p>Any questions, please email client support services here: info@livewitnessapp.net</p>";
            // $txt .= "<p>&nbsp;</p>";
            // $txt .= "<p>Any questions, please email client support services here: info@livewitnessapp.net</p>";
            // $txt .= "<p style='background-color:#CCC; text-align:left; padding:5px; border:1px solid #999'>NOTICE: This email and any attachments contain confidential information intended only for the individual(s) named above. You are strictly prohibited from any unauthorized use, disclosure, distribution, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email. If you have received this email in error, please notify the sender immediately and delete/destroy any and all copies of the original message. If you are not the intended recipient you are further notified that disclosing, copying, distributing, broadcasting, web site posting, hyperlinking to, saving to disk or forwarding this email or taking any action in reliance upon the contents of this information is strictly prohibited.</p>";
            // $txt .= "</body></html>";
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";    // Always set content-type when sending HTML email
            // $headers .= 'From: '.PRODUCT_TITLE.'<info@livewitnessapp.net>' . "\r\n";
            // $headers .= 'Bcc: <'.BCC.'>';
            // mail($to,$subject,$txt,$headers);
        }

    }

    // static function generateUserFirebase($users) {



    //            $url = FIREBASE_PATH.'users/'.$users->fldUsersCommanderID.'.json';
    //             if($users->fldUserStatus == 1) {
    //                 $userStatus = "agent";
    //             } else if($users->fldUserStatus == 0) {
    //                 $userStatus = "transport";
    //             }

    //             $arr = array($userStatus => array("accesscode"=>$users->fldUsersAccessCode, "name" =>$users->fldUsersFullname));

    //             $data_string = json_encode($arr);

    //             $ch = curl_init($url);
    //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //             curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                 'Content-Type: application/json',
    //                 'Content-Length: ' . strlen($data_string))
    //             );

    //             $result = curl_exec($ch);

    // }

    // static function removeUserFirebase($users) {

    //             if($users->fldUserStatus == 1) {
    //                 $userStatus = "agent";
    //             } else if($users->fldUserStatus == 0) {
    //                 $userStatus = "transport";
    //             }

    //              $url = FIREBASE_PATH.'users/'.$users->fldUsersCommanderID.'/'.$userStatus.'.json';

    //             $ch = curl_init($url);
    //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


    //             $result = curl_exec($ch);


    // }

    static function generateUserFirebase($users,$eventID) {


      if($users->fldUserStatus == 1) {
          $userStatus = "agent";
          $commanderID = $users->fldUsersCommanderID;
      } else if($users->fldUserStatus == 0) {
          $userStatus = "transport";
          $commanderID = $users->fldUsersCommanderID;
      } else if($users->fldUserStatus == 2) {
          $userStatus = "commander";
          $commanderID = $users->fldUserID;
      }

     $url = FIREBASE_PATH.'users/'.$commanderID.'/'.$userStatus.'.json';
                //$eventID = $eventID + 1;

                //$arr = array($userStatus => array("accesscode"=>$users->fldUsersAccessCode, "name" =>$users->fldUsersFullname));
               $arr = array("accesscode"=>$users->fldUsersAccessCode, "name" =>$users->fldUsersFullname,"eventID" =>$eventID,"contact_no"=>$users->fldUsersMobile,"user_remote_activate"=>true,"user_remote_activate_video"=>true);

                $data_string = json_encode($arr);

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
                );

                $result = curl_exec($ch);
                Log::debug("Start Streaming Results");
                Log::debug($result);

                return $result;

    }

    static function removeUserFirebase($users) {

                if($users->fldUserStatus == 1) {
                    $userStatus = "agent";
                } else if($users->fldUserStatus == 0) {
                    $userStatus = "transport";
                }


                $url = FIREBASE_PATH.'users/'.$users->fldUsersCommanderID.'/'.$userStatus.'/'.$users->fldUserFirebaseKey.'.json';

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


                $result = curl_exec($ch);


                //remove user location via user accesscode
                if($users->fldUsersAccessCode != "") {
                    $url = FIREBASE_PATH.'user_location/'.$users->fldUsersAccessCode.'.json';

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


                    $result = curl_exec($ch);
                }


    }

    static function removeUserRemoteControl($users) {
                if($users->fldUserStatus == 1) {
                    $userStatus = "agent";
                } else if($users->fldUserStatus == 0) {
                    $userStatus = "transport";
                }

                //remove users from remote controller
                if($users->fldUsersAccessCode != "") {
                  $url = FIREBASE_PATH.'remote_control/'.$users->fldUsersCommanderID.'/'.$userStatus.'/'.$users->fldUsersAccessCode.'.json';

                  $ch = curl_init($url);
                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


                  $result = curl_exec($ch);
                }
    }


    static function removeActiveUser($users) {
      if($users->fldUsersAccessCode != "") {
        $url = FIREBASE_PATH.'active_user/'.$users->fldUsersAccessCode.'.json';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        $result = curl_exec($ch);
      }
    }


    static function recordUserForceStop($users) {

                $userRec = self::find($users->fldUserID);
                if(count($userRec) == 1) {
                   $userRec->fldIsCrashApp = 1;
                   $userRec->save();
                }

                if($users->fldUserStatus == 1) {
                    $userStatus = "agent";
                } else if($users->fldUserStatus == 0) {
                    $userStatus = "transport";
                }


                $url = FIREBASE_PATH.'users-force-stop-console/'.$userStatus.'.json';

                $arr = array("accesscode"=>$users->fldUsersAccessCode, "name" =>$users->fldUsersFullname,"date"=>date('F d, Y h:i:s'));

                 $data_string = json_encode($arr);

                 $ch = curl_init($url);
                 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                     'Content-Type: application/json',
                     'Content-Length: ' . strlen($data_string))
                 );

                 $result = curl_exec($ch);


    }



    static function deleteMultipleLocationFirebase($accesscode) {
        $url = FIREBASE_PATH.'multiple_location/'.$accesscode.'.json';


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        $result = curl_exec($ch);





    }

    static function deleteUserLocationFirebase($accesscode) {
      //delete in user location
      $url = FIREBASE_PATH.'user_location/'.$accesscode.'.json';


      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


      $result = curl_exec($ch);
    }

    static function deleteVideoData($accesscode) {



              //delete in video
              $url = FIREBASE_PATH.'video/'.$accesscode.'.json';

              $ch = curl_init($url);
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


              $result = curl_exec($ch);
    }

    static function updateSecurityCode($usersID,$securityCode) {
        $users = self::where('fldUserID','=',$usersID)
                     ->first();
        if(count($users) == 1) {
           $users->fldUserSecurityCode = $securityCode;
           $users->save();
        }
    }


    static function deleteMultipleLocationFirebaseByEvent($accesscode,$eventid) {
      $url = FIREBASE_PATH.'multiple_location/'.$accesscode.'.json?event_id='.$eventid;


      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

      $result = curl_exec($ch);
    }


    static function deleteVideoDataByEvents($accesscode,$eventid) {
      $url = FIREBASE_PATH.'video/'.$accesscode.'.json?event_id='.$eventid;


      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

      $result = curl_exec($ch);
    }


}
