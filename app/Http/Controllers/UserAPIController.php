<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\DataStorage;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Hash;
use Auth;
    use Log;

class UserAPIController extends Controller
{

    function CheckLogin() {
        $username = Input::get('username');
        $password = Input::get('password');

        $checkAccess = false;

        $userRec = Users::where('fldUsersEmail','=',$username)->first();
        if(count($userRec) == 0) {
            //check username
            $userRec = Users::where('fldUsersUserName','=',$username)->first();
            if(count($userRec) == 1) {
               $checkAccess = true;
            }
        } else {
            $checkAccess = true;
        }


        if($checkAccess == true) {
            if (Hash::check($password, $userRec->fldUsersPassword)) {
              //Users::generateUserFirebase($userRec,0);

              $agent = Users::where('fldUsersCommanderID','=',$userRec->fldUserID)
                            ->select('fldUsersFullname','fldUsersMobile','fldUserCountryCode')
                            ->where('fldUserLevel','=','agent')
                            ->get();

              $transport =  Users::where('fldUsersCommanderID','=',$userRec->fldUserID)
                            ->select('fldUsersFullname','fldUsersMobile','fldUserCountryCode')
                            ->where('fldUserLevel','=','transport')
                            ->get();

                return Response::json(array(
                         'error' => false,
                         'users'=> $userRec->toArray(),
                         'agent'=>$agent->toArray(),
                         'transport'=>$transport->toArray(),
                         'message' => "success."),
                         200
                );

            } else {
              return Response::json(array(
                       'error' => true,
                       'message' => "Invalid username or password."),
                       200
              );
            }
        } else {
          return Response::json(array(
                   'error' => true,
                   'message' => "Invalid username or password."),
                   200
          );
        }



    }


    function DisplayAllUser() {
      $commanderID = Input::get('commander_id');
      $userRec = Users::find($commanderID);
      if(count($userRec) == 1) {

            $agent = Users::where('fldUsersCommanderID','=',$userRec->fldUserID)
                          ->select('fldUsersFullname','fldUsersMobile','fldUserCountryCode')
                          ->where('fldUserLevel','=','agent')
                          ->get();

            $transport =  Users::where('fldUsersCommanderID','=',$userRec->fldUserID)
                          ->select('fldUsersFullname','fldUsersMobile','fldUserCountryCode')
                          ->where('fldUserLevel','=','transport')
                          ->get();

              return Response::json(array(
                       'error' => false,
                       'users'=> $userRec->toArray(),
                       'agent'=>$agent->toArray(),
                       'transport'=>$transport->toArray(),
                       'message' => "success."),
                       200
              );
        } else {
          return Response::json(array(
                   'error' => true,
                   'message' => "Invalid access."),
                   200
          );
        }

    }


    function DisplayCommander() {
       $commander_id = Input::get('commander_id');
       $user = Users::find($commander_id);
       if(count($user) == 1) {
           return Response::json(array(
                    'error' => false,
                    'users'=> $user->toArray(),
                    'message' => "success."),
                    200
           );
       } else {
         return Response::json(array(
                  'error' => true,
                  'message' => "Commander Record not Found."),
                  200
         );
       }
    }


    function ClearAudio($commander_id) {

      $url = FIREBASE_PATH.'audio_recording/'.$commander_id.'.json';
      //echo $url;die();

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


      $result = curl_exec($ch);

      print_r($result);
    }


    function UpdateUserRemoteControlStatus() {
      $usercode = Input::get('usercode');
      $user_remote_activate = Input::get('user_remote_activate');
      $user_remote_activate_video = Input::get('user_remote_activate_video');

      $arr = array("user_remote_activate"=>$user_remote_activate,"user_remote_activate_video"=>$user_remote_activate_video);

      $url = FIREBASE_PATH.'remote_control/'.$usercode.'.json';

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


      function UserLogin() {
       $username = Input::get('username');
       $password = Input::get('password');

       $userRec = Users::where('fldUsersUserName','=',$username)->first();
       if($userRec) {
           if (Hash::check($password, $userRec->fldUsersPassword)) {
               
               $response = DataStorage::CheckDataStorageByCommander($userRec->fldUsersCommanderID);
               $data_usage = $response->data_usage;
               $data_usage_in_mb = $response->data_usage_in_mb;
               
              // Log::debug("UserLogin");
               //Log::info(print_r($response, true));
               if($response->error == true) {
                   return Response::json(array(
                                               'error' => true,
                                               'data_usage' => $data_usage,
                                               'data_usage_in_mb' => $data_usage_in_mb,
                                               'upgrade_account' => $response->upgrade_account,
                                               'message' => $response->message),
                                         200
                                         );
               }
               
               
              $accesscode = $userRec->fldUsersAccessCode;
               $alertDetails = AlertDetails::where('user_code','=',$accesscode)
                                           ->where('location_now','!=','')
                                           ->orderBy('alert_detail_id','DESC')
                                           ->first();
               if(count($alertDetails) == 0) {
                 $lasteventID = 1;
               } else {
                 $lasteventID = $alertDetails->events;
               }

               if($userRec->fldUsersNextEvent == 0) {
                  $nextEventID = 1;
               } else {
                 $nextEventID = $userRec->fldUsersNextEvent;
               }

          //generate users information to users
          //$userRec = Users::generateUserFirebase($users);
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $token = substr(str_shuffle(str_repeat($pool, 55)), 0, 55);

            $userRec->fldUserAPIToken = $token;
            $userRec->save();


               return Response::json(array(
                        'error' => false,
                        'lasteventID'=>$nextEventID,
                        'token'=>$token,
                        'userInfo'=>$userRec->toArray(),
                        'data_usage' => $data_usage,
                        'data_usage_in_mb' => $data_usage_in_mb,
                        'accesscode' => $userRec->fldUsersAccessCode,
                        'message' => "success."),
                        200
               );
           } else {

             return Response::json(array(
                      'error' => true,
                      'upgrade_account' => false,
                      'message' => "Invalid username or password."),
                      200
             );

           }
       } else {
          //invalid email address
          return Response::json(array(
                   'error' => true,
                   'upgrade_account' => false,
                   'message' => "Invalid username or password."),
                   200
          );

       }
    }



}
