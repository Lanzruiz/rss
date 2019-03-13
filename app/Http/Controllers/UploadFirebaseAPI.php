<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Jobs\TransferVideoToS3;
use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\DataStorage;


use Response;
use File;
use View;
use Input;
use Log;

class UploadFirebaseAPI extends Controller
{

    public function displayUpload() {

    	return View::make('upload.display');
    }


    public function upload() {
        //$file = Input::file('video');
        $type = Input::get('type');
        $filename = Input::get('filename');
        $deviceID = Input::get('accesscode');
        $date = date('F d, Y');
        $time = date('H:i a');

        $accel = Input::get('accel');
        $alert_battery_level = Input::get('alert_battery_level');
        //$alert_datetime = date('Y-m-d h:i');
        $alert_datetime = Input::get('tds') &&  Input::get('tds') != "" ? Input::get('tds') :  date('Y-m-d H:i');
        $alert_gps_files = Input::get('alert_gps_files');
        $alert_media_files = Input::get('alert_media_files');
        $alert_speed = Input::get('alert_speed');
        $course = Input::get('course');
        $direction = Input::get('direction');
        $elevation = Input::get('elevation');
        $event_id = Input::get('event_id');
        $lat = Input::get('lat');
        $level = Input::get('level');
        $lng = Input::get('lng');
        $location_now = Input::get('location_now');
        $online_status = Input::get('online_status');
        $type = "Video";
        $user_access_code = $deviceID;
        $floor = Input::get("floor");
        $distance = Input::get("distance") &&  Input::get('distance') != "" ? Input::get('distance') : "";
        $distanceType = Input::get('distanceType') &&  Input::get('distanceType') != "" ? Input::get('distanceType') : "miles";

        //$event_id = 1;

        //$newAccessCode = str_replace('"', '', $deviceID);

        Log::debug('Access Code Upload API: ' . $deviceID);
        Log::debug('Event ID  Upload API: ' . $event_id);
        Log::debug(Input::all());


        $users = Users::where('fldUsersAccessCode','=',$deviceID)
                        ->first();

        Log::debug('Users: ' . $users);

        if(count($users) == 0) {
              Log::debug('Users not found');
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code."),
                     200
            );
        }

         $auth_level = $users->fldUserStatus;
         $client_id = $users->fldUserID;
         $multipleLocationKey = $users->fldUserMultipleLocationKey;

         Log::debug('Users found');



        //$temp = file_get_contents($file);
    //$blob = base64_encode($temp);
    // if($file != "") {
    //  $filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.$file->getClientOriginalExtension();
    // } else {
    //   $filename = "";
    // }

    //echo $blob;die();
    //     $filename = "";
       if($type == "Video") {
        //$url = FIREBASE_PATH.'video/'.$deviceID.'/'.$event_id.'.json';
        $url = FIREBASE_PATH.'video/'.$deviceID.'/'.'.json';
        $destinationPath = VIDEO_PATH.$deviceID.'/'.$event_id.'/';
      } else {
        //$url = FIREBASE_PATH.'audio/'.$deviceID.'/'.$event_id.'.json';
        $url = FIREBASE_PATH.'audio/'.$deviceID.'/'.'.json';
        $destinationPath = AUDIO_PATH.$deviceID.'/'.$event_id.'/';
      }
        
      if($users->fldUserLoggedStatus == 1) {


        Log::debug("Firebase saving");

      $arr = array("distanceType"=>$distanceType,"distance"=>$distance,"floor"=>$floor,"accel"=>$accel, "alert_battery_level"=>$alert_battery_level, "alert_datetime"=>$alert_datetime, "alert_gps_files"=>$alert_gps_files, "alert_media_files"=>$alert_media_files, "alert_speed"=>$alert_speed, "auth_level"=>$auth_level, "client_id"=>$client_id, "course"=>$course, "direction"=>$direction, "elevation"=>$elevation, "event_id"=>$event_id, "filename"=>$filename, "lat"=>$lat, "level"=>$level,  "lng"=>$lng, "location_now"=>$location_now,"online_status"=>$online_status,"type"=>$online_status,"user_access_code"=>$user_access_code, "date"=>$date,"time"=>$time,"refresh_status"=>"true");

      //Log::debug("Firebase Array: ".$arr);

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





    //$filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.$file->getClientOriginalExtension();
    // if($file != "") {
    //   $file->move($destinationPath, $filename);
    // }


          //$path = public_path('videos/'.$filename);
          
//          $videoFilename = $users->fldUsersAccessCode .'-'.$event_id.'.flv';
//          $path = public_path('videos/'.trim($videoFilename));
//          Log::debug("Save Streaming");
//          Log::debug($path);
//          $filesize = 0;
//          try {
//              $filesize = File::size($path);
//          } catch(\Exception $e) {
//              Log::debug('Caught exception: '.  $e->getMessage());
//          }
          
    //Save data to Alert Details Table
    $alertDetails = (object) ['user_id' => $users->fldUserID,
                              'user_name' => $users->fldUsersFullname,
                              'alert_datetime' => $alert_datetime,
                              'event_id' => $event_id,
                              'status' => $users->fldUserStatus,
                              'client_id' => $users->fldUsersCommanderID,
                              'lat' => $lat,
                              'lng' => $lng,
                              'location_now' => $location_now,
                              'alert_battery_level' => $alert_battery_level,
                              'alert_speed' => $alert_speed,
                              'direction' => $direction,
                              'elevation' => $elevation,
                              'course' => $course,
                              'level' => $level,
                              'accel' => $accel,
                              'filePath'=>$filename,
                              'fileType' => 'video',
                              'user_code'=>$deviceID,
                              "floor"=>$floor,
                              "distance"=>$distance,
                              "distanceType"=>$distanceType,
                              'multiple_location_key'=>$multipleLocationKey
                             ];

       //Log::debug("Alert Details " . $alertDetails);

     AlertDetails::saveDataAlertDetails($alertDetails);

       Log::debug("MYSQL saving");

    return Response::json(array(
                     'error' => false,
                     'message' => "Video was successfully uploaded."),
                     200
        );

  }


    }

    public function getAlertDetails() {
       $accesscode = Input::get('accesscode');
       $event_id = Input::get('event_id');

        $users = Users::where('fldUsersAccessCode','=',$accesscode)
                        ->first();


        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),
                     200
            );
        }

         //check if accesscode and event is already exist
        $userData = AlertDetails::where('user_code','=',$accesscode)
                          ->where('events','=',$event_id)
                          ->first();

         if(count($userData) == 0) {
            return Response::json(array(
                     'error' => false,
                     'message' => "No user data was found."),
                     200
            );
         }  else {
          return Response::json(array(
                     'error' => true,
                     'userData' => $userData->toArray()),
                     200
            );
         }




    }


    public function updateUploadMobile() {
        $lat = Input::get('lat');
        $lng = Input::get('lng');
        $direction = Input::get('direction');
        $speed = Input::get('speed');
        $accesscode = Input::get('accesscode');
        $event_id = Input::get('event_id');
        $location_now = Input::get('location_now');

       // $event_id = 1;

        $users = Users::where('fldUsersAccessCode','=',$accesscode)
                        ->first();


        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),
                     200
            );
        }


      if($users->fldUserLoggedStatus == 1)  {
        //check if accesscode and event is already exist
        $userData = AlertDetails::where('user_code','=',$accesscode)
                          ->where('events','=',$event_id)
                          ->first();
        if(count($userData) == 0) {
            $alertDetails = new AlertDetails;
                 $alertDetails->user_code = $accesscode;
                 $alertDetails->events = $event_id;
        }  else {
            $alertDetails = AlertDetails::where('user_code','=',$accesscode)
                          ->where('events','=',$event_id)
                          ->first();
        }

            $alertDetails->lat = $lat;
            $alertDetails->lng = $lng;
            $alertDetails->direction = $direction;
            $alertDetails->alert_speed = $speed;
            $alertDetails->location_now = $location_now;

            $alertDetails->save();

              return Response::json(array(
                     'error' => false,
                     'message' => "Details are successfully saved."),
                     200
              );
         }

    }


  //   public function upload() {
  //      	$file = Input::file('video');
  //      	$type = Input::get('type');
  //      	$deviceID = Input::get('accesscode');
  //      	$date = date('F d, Y');
  //      	$time = date('h:i:s a');

  //      	//$temp = file_get_contents($file);
		// //$blob = base64_encode($temp);
  //   	$filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.$file->getClientOriginalExtension();
		// //echo $blob;die();
		// 	if($type == "video") {
		// 		$url = FIREBASE_PATH.'video/'.$deviceID.'.json';
		// 		$destinationPath = VIDEO_PATH;
		// 	} else {
		// 		$url = FIREBASE_PATH.'audio/'.$deviceID.'.json';
		// 		$destinationPath = AUDIO_PATH;
		// 	}

		// 	$arr = array("filename"=>$filename,"date"=>$date,"time"=>$time);
		// 	$data_string = json_encode($arr);
		// 	$ch = curl_init($url);
		// 		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 		'Content-Type: application/json',
		// 		'Content-Length: ' . strlen($data_string))
		// 		);

		// 	$result = curl_exec($ch);





		// $filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.$file->getClientOriginalExtension();
		// $file->move($destinationPath, $filename);

		// return Response::json(array(
  //                    'error' => false,
  //                    'message' => "Video was successfully uploaded"),
  //                    200
  //       );


  //   }

  //   public function location() {
  //   	$deviceID = Input::get('accesscode');
  //   	$lat = Input::get('lat');
  //   	$lon = Input::get('lon');

  //       Log::debug($deviceID . ' ' . $lat . ' ' . $lon);

  //   	$users = Users::where('fldUsersAccessCode','=',$deviceID)
  //   					->first();

  //   	if(count($users) == 0) {
  //   		return Response::json(array(
  //                    'error' => true,
  //                    'message' => "Invalid Access Code"),
  //                    200
  //       	);
  //   	}

  //   	$url = FIREBASE_PATH.'user_location.json';
		// 		$arr = array($deviceID =>array("lat"=>$lat, "lon" =>$lon));
		// 		$data_string = json_encode($arr);
		// 		$ch = curl_init($url);
		// 		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
		// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 		'Content-Type: application/json',
		// 		'Content-Length: ' . strlen($data_string))
		// 		);

		// 		$result = curl_exec($ch);

		// return Response::json(array(
  //                    'error' => false,
  //                    'message' => "Location was successfully saved."),
  //                    200
  //       );

  //   }

    public function location() {
        $deviceID = Input::get('accesscode');
        $lat = Input::get('lat');
        $lon = Input::get('lon');
        $location= Input::get('location_now');
        $online_status = Input::get("online_status");
        //$updated_date = date('Y-m-d H:i');
        $updated_date = Input::get('tds') &&  Input::get('tds') != "" ? Input::get('tds') :  date('Y-m-d H:i');

        $event_id = Input::get("eventid");
        //$tds = date('Y-m-d H:i');
        $tds = Input::get('tds') &&  Input::get('tds') != "" ? Input::get('tds') :  date('Y-m-d H:i');
        $speed = Input::get("speed");
        $elevation = Input::get("elevation");
        $direction = Input::get("direction");
        $battery_level = Input::get("batterylevel");
        $distance = Input::get("distance") &&  Input::get('distance') != "" ? Input::get('distance') : "";
        $distanceType = Input::get('distanceType') &&  Input::get('distanceType') != "" ? Input::get('distanceType') : "miles";
        $magneticHeading = Input::get('magneticHeading');

      //  Log::debug($deviceID . ' ' . $lat . ' ' . $lon);

        $users = Users::where('fldUsersAccessCode','=',$deviceID)
                        ->first();

        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code."),
                     200
            );
        }


      if($users->fldUserLoggedStatus == 1) {

        $auth_level = $users->fldUserStatus;

        //$event_id = $users->fldUsersNextEvent;
        $lastUpdate = date('Y-m-d h:i:s');

        $url = FIREBASE_PATH.'user_location.json';
                $arr = array($deviceID =>array("distanceType"=>$distanceType,"distance"=>$distance,"lastUpdatedDate"=>$lastUpdate,"auth_level"=>$auth_level, "client_id"=>$users->fldUserID, "lat"=>$lat, "lon" =>$lon, "location_now"=>$location,"online_status"=>$online_status,"updated_date"=>$updated_date,"user_access_code"=>$deviceID, "event_id"=>$event_id, "tds"=>$tds, "speed" => $speed, "elevation" => $elevation, "direction" => $direction, "battery_level"=>$battery_level,
            		"magneticHeading" => $magneticHeading));

                $data_string = json_encode($arr);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
                );

                $result = curl_exec($ch);

         $url = FIREBASE_PATH.'multiple_location/'.$deviceID.'/'.$users->fldUserMultipleLocationKey.'.json';
           $arr = array("distanceType"=>$distanceType,"distance"=>$distance,"auth_level"=>$auth_level, "client_id"=>$users->fldUserID, "lat"=>$lat, "lon" =>$lon, "location_now"=>$location,"online_status"=>$online_status,"updated_date"=>$updated_date,"user_access_code"=>$deviceID, "event_id"=>$event_id, "tds"=>$tds, "speed" => $speed, "elevation" => $elevation, "direction" => $direction, "battery_level"=>$battery_level,"magneticHeading" => $magneticHeading);

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


        return Response::json(array(
                     'error' => false,
                     'message' => "Location was successfully saved."),
                     200
        );
      }

    }

    public function videoStream() {
    	return View::make('stream.stream');
    }


    public function checkAccessCode() {
    	$accesscode = Input::get('accesscode');
      $userType = strtolower(Input::get('userType'));

    	// $users = Users::where('fldUsersAccessCode','=',$accesscode)
      //                 ->where('fldUserLevel','=',$userType)
    	// 				        ->first();


      $users = Users::where('fldUsersAccessCode','=',$accesscode)
    					       ->first();

    	if(count($users) == 0) {
    		return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),
                     200
        	);
    	} else {
         //check the last event no
            $alertDetails = AlertDetails::where('user_code','=',$accesscode)
                                        ->where('location_now','!=','')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->first();
            if(count($alertDetails) == 0) {
              $lasteventID = 1;
            } else {
              $lasteventID = $alertDetails->events;
            }

            if($users->fldUsersNextEvent == 0) {
               $nextEventID = 1;
            } else {
              $nextEventID = $users->fldUsersNextEvent;
            }

    		//generate users information to users
    		//$userRec = Users::generateUserFirebase($users);
         $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $token = substr(str_shuffle(str_repeat($pool, 55)), 0, 55);

         $users->fldUserAPIToken = $token;
         $users->save();


    		return Response::json(array(
                     'error' => false,
                     'userInfo'=>$users->toArray(),
                     'lasteventID'=>$nextEventID,
                     'token'=>$token,
                     'message' => "Access code is valid."),
                     200
        	);
    	}

    }

    // function startStreaming() {
    //     $accesscode = Input::get('accesscode');

    //     $users = Users::where('fldUsersAccessCode','=',$accesscode)
    //                     ->first();

    //     if(count($users) == 0) {
    //         return Response::json(array(
    //                  'error' => true,
    //                  'message' => "Invalid Access Code"),
    //                  200
    //         );
    //     } else {

    //         //generate users information to users
    //         $userRec = Users::generateUserFirebase($users);

    //         return Response::json(array(
    //                  'error' => true,
    //                  'userInfo'=>$users->toArray(),
    //                  'message' => "Access code is valid"),
    //                  200
    //         );
    //     }
    // }

    // public function stopStreaming() {
    // 	$accesscode = Input::get('accesscode');
    // 	$users = Users::where('fldUsersAccessCode','=',$accesscode)
    // 					->first();

    // 	if(count($users) == 0) {
    // 		return Response::json(array(
    //                  'error' => true,
    //                  'message' => "Invalid Access Code"),
    //                  200
    //     	);
    // 	} else {

    // 		$userRec = Users::removeUserFirebase($users);

    // 		return Response::json(array(
    //                  'error' => true,
    //                  'userInfo'=>$users->toArray(),
    //                  'message' => "Stop Streaming successfull"),
    //                  200
    //     	);
    // 	}
    // }


    function startStreaming() {
        $accesscode = Input::get('accesscode');
        Log::debug("Start accesscode " . $accesscode);
        $users = Users::where('fldUsersAccessCode','=',$accesscode)
                        ->first();

        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),
                     200
            );
        } else {
            
            $response = DataStorage::CheckDataStorageByCommander($users->fldUsersCommanderID);
            $data_usage = $response->data_usage;
            $data_usage_in_mb = $response->data_usage_in_mb;
            
            //change the logged status to login
            $users->fldUserLoggedStatus = 1;
            $users->save();


             //check the last event no
            $alertDetails = AlertDetails::where('user_code','=',$accesscode)
                                        ->where('location_now','!=','')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->first();
            if(count($alertDetails) == 0) {
              $lasteventID = 1;
              //$nextEventID = 1;
            } else {
              $lasteventID = $alertDetails->events;
              //$lasteventIDIncrement = $alertDetails->events + 1;
              //$nextEventID = $lasteventIDIncrement;

            }

            if($users->fldUsersNextEvent == 0) {
               $nextEventID = 1;
            } else {
              $nextEventID = $users->fldUsersNextEvent;
            }



            //generate users information to users
            if($users->fldUserFirebaseKey == "" || $users->fldIsCrashApp == 1) {
                $userRec = Users::generateUserFirebase($users,$nextEventID);
                $userKey = json_decode($userRec);


                $users->fldUserFirebaseKey = $userKey->name;

            }

            $users->fldUserMultipleLocationKey = str_random(20);

            $users->save();

            //send sms to agent and/or commander
            SMS::StartFeedsSMS($users);

            //get commander accesscode

            $transRec = Users::where('fldUserID','=',$users->fldUsersTransportID)->first();
            $transAccessCode = count($transRec) == 1  ? $transRec->fldUsersAccessCode : "";

            if($users->fldUserCountryID != "") {
              $userMobile = $users->fldUserCountryCode . $users->fldUsersMobile;
            } else {
              $userMobile = $users->fldUsersMobile;
            }

            Log::debug("********User Info*********");
            Log::debug($users);

            return Response::json(array(
                     'error' => false,
                     'userInfo'=>$users->toArray(),
                     'lasteventID'=>$nextEventID,
                     'commanderID'=>$users->fldUsersCommanderID,
                     'contact_no' => $userMobile,
                     'data_usage' => $data_usage,
                     'data_usage_in_mb' => $data_usage_in_mb,
                     'transAccessCode'=>$transAccessCode,
                     'message' => "Access code is valid."),
                     200
            );
        }
    }

    public function stopStreaming() {
        $accesscode = Input::get('accesscode');
        Log::debug("Stop Streaming");
        Log::debug($accesscode);
        
        $users = Users::where('fldUsersAccessCode','=',$accesscode)
                        ->first();
        
        //Log::info(print_r($users, true));

        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code."),
                     200
            );
            
            Log::debug("No Users");
        } else {

            $userRec = Users::removeUserFirebase($users);

            $users->fldUserFirebaseKey = "";
            $users->fldUserLoggedStatus = 0;
            $users->fldIsCrashApp == 0;
            $users->save();

            $userEvent = AlertDetails::where('user_code','=',$accesscode)
                              ->orderBy('events','DESC')
                              ->first();
            
            Log::info(print_r($userEvent, true));
            
            if($userEvent) {
                $videoFilename = $accesscode .'-'.$userEvent->events.'.flv';
                $path = public_path('videos/'.trim($videoFilename));
                $filesize = 0;
                try {
                    $filesize = File::size($path);
                } catch(\Exception $e) {
                    Log::debug('Caught exception: '.  $e->getMessage());
                }
                
                $userEvent->feeds_filesize = $filesize;
                $userEvent->save();
            }

            if(count($userEvent) == 1) {
                $event = $userEvent->events + 1;

                $users = Users::where('fldUsersAccessCode','=',$accesscode)->first();
                  $users->fldUsersNextEvent = $event;
                $users->save();
            }

            //send sms to agent and/or commander
            SMS::StopFeedsSMS($users);

            dispatch(new TransferVideoToS3($userEvent));
            
            Log::debug("End Stop Streaming");
            return Response::json(array(
                     'error' => false,
                     'userInfo'=>$users->toArray(),
                     'message' => "Stop Streaming is Successfull."),
                     200
            );
        }
    }


    public function stopStreamingWeb() {
        $accesscode = Input::get('accesscode');
        $users = Users::where('fldUsersAccessCode','=',$accesscode)
                        ->first();

        if(count($users) == 0) {
            echo "Invalid access code";
        } else {
            $userRec = Users::removeUserFirebase($users);
            $userForce = Users::recordUserForceStop($users);
            $userRemote = Users::removeUserRemoteControl($users);
            $userActive = Users::removeActiveUser($users);

            echo "Stop Streaming successfull";

        }
    }


    function deleteFirebaseData($accesscode) {
        $url = FIREBASE_PATH.'multiple_location/'.$accesscode.'.json';


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        $result = curl_exec($ch);

        print_r($result);
    }


    function streamingSecurity() {
         $accesscode = Input::get('accesscode');
         $token = Input::get('token');
         $user = Users::where('fldUsersAccessCode','=',$accesscode)
                      ->where('fldUserAPIToken','=',$token)
                      ->first();

         if(count($user) == 0) {
           //echo "Invalid Access!";
           //Log::debug("Invalid Access");
           header('HTTP/1.0 400 Not Found');
         } else {
            //echo "Access is valid!";
            //Log::debug("Access was valid");
            header ( "HTTP/1.0 200 OK" );
         }
         exit();


     }


     public function transportThreat($accesscode) {
          $user = Users::where('fldUsersAccessCode','=',$accesscode)
                       ->first();

           if(count($user) == 0) {
                 return Response::json(array(
                          'error' => true,
                          'message' => "Invalid Access Code."),
                          200
                 );
           } else {
                 $message = $user->fldUsersFullname." is under threat!";
                 $subject = $user->fldUsersFullname." is under threat!";

                 //send sms to commander
                 $commander = Users::where('fldUserID','=',$user->fldUsersCommanderID)->first();
                 if(count($commander) == 1) {
                      //send sms to commander
                      SMS::sendEmail($commander,$message,$subject);
                      $areaCode = $commander->fldUserCountryCode;
                      SMS::sendSMS($areaCode.$commander->fldUsersMobile,$message,$commander->fldUserID);
                 }

                 //send sms to agent
                 $agent = Users::where('fldUsersTransportID','=',$user->fldUserID)
                              ->get();

                if(count($agent) > 0 ) {
                    foreach($agent as $agents) {
                        if($agents->fldUsersMobile != "") {
                          //send sms to agents
                          SMS::sendEmail($agents,$message,$subject);
                          $areaCode = $agents->fldUserCountryCode;
                          SMS::sendSMS($areaCode.$agents->fldUsersMobile,$message,$agents->fldUserID);
                        }
                    }
                }


                return Response::json(array(
                         'error' => false,
                         'message' => "SMS was successfully sent."),
                         200
                );

           }

     }
    
    
    
    
    function CheckUserDataUsage() {
        $accesscode = Input::get('accesscode');
        
        $users = Users::where('fldUsersAccessCode','=',$accesscode)
        ->first();
        
        if(count($users) == 0) {
            return Response::json(array(
                                        'error' => true,
                                        'message' => "Invalid Access Code"),
                                  200
                                  );
        } else {
            
            $response = DataStorage::CheckDataStorageByCommander($users->fldUsersCommanderID);
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
            } else {
                return Response::json(array(
                                            'error' => false,
                                            'data_usage' => $data_usage,
                                            'data_usage_in_mb' => $data_usage_in_mb,
                                            'upgrade_account' => false,
                                            'message' => "continue..."),
                                      200
                                      );
            }
            
        }
    }
    
    
    
    function CheckCurrentDataUsage() {
        $accesscode = Input::get('accesscode');
        $event_id = Input::get('event_id');
        
        
        $videoFilename = $accesscode .'-'.$event_id.'.flv';
        $path = public_path('videos/'.trim($videoFilename));
        $filesize = 0;
        try {
            $filesize = File::size($path);
        } catch(\Exception $e) {
            Log::debug('Caught exception: '.  $e->getMessage());
        }
        
        
        
        $convertKB = $filesize * 0.001;
        $current_filesize = $convertKB * 0.001; //filesize in MB
        //$current_filesize = $filesize * 0.0000009537;
        
        Log::debug("CheckCurrentDataUsage");
        Log::debug("Bytes: ".$filesize);
        Log::debug("convertKB: ".$convertKB);
        Log::debug("convertMB: ".$current_filesize);
        
        $users = Users::where('fldUsersAccessCode','=',$accesscode)
        ->first();
        
        if($users) {
            $response = DataStorage::CheckDataStorageByCommander($users->fldUsersCommanderID, $current_filesize);
            $data_usage = $response->data_usage;
            $data_usage_in_mb = $response->data_usage_in_mb;
            
            if($response->error == true) {
                return Response::json(array(
                                            'error' => true,
                                            'data_usage' => $data_usage,
                                            'data_usage_in_mb' => $data_usage_in_mb,
                                            'upgrade_account' => $response->upgrade_account,
                                            'message' => $response->message),
                                      200
                                      );
            } else {
                return Response::json(array(
                                            'error' => false,
                                            'data_usage' => $data_usage,
                                            'data_usage_in_mb' => $data_usage_in_mb,
                                            'upgrade_account' => false,
                                            'message' => "continue..."),
                                      200
                                      );
            }
            
        } else {
            return Response::json(array(
                                        'error' => false,
                                        'filesize' => $current_filesize,
                                        'message' => "continue..."),
                                  200
                                  );
        }
        
        
        
        
    }


}
