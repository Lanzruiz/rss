<?php
/***********************PROGRAMMER : EMMANUEL MARCILLA**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Users;
use App\Models\AlertDetails;


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
        $time = date('h:i:s a');

        $accel = Input::get('accel');
        $alert_battery_level = Input::get('alert_battery_level'); 
        $alert_datetime = date('Y-m-d h:i:s');
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

        //$newAccessCode = str_replace('"', '', $deviceID);

        Log::debug('Access Code: ' . $deviceID);


        $users = Users::where('fldUsersAccessCode','=',$deviceID)
                        ->first();

        Log::debug('Users: ' . $users);                

        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),  
                     200
            );
        }

         $auth_level = $users->fldUserStatus;
         $client_id = $users->fldUserID;
         $multipleLocationKey = $users->fldUserMultipleLocationKey;




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



      $arr = array("accel"=>$accel, "alert_battery_level"=>$alert_battery_level, "alert_datetime"=>$alert_datetime, "alert_gps_files"=>$alert_gps_files, "alert_media_files"=>$alert_media_files, "alert_speed"=>$alert_speed, "auth_level"=>$auth_level, "client_id"=>$client_id, "course"=>$course, "direction"=>$direction, "elevation"=>$elevation, "event_id"=>$event_id, "filename"=>$filename, "lat"=>$lat, "level"=>$level,  "lng"=>$lng, "location_now"=>$location_now,"online_status"=>$online_status,"type"=>$online_status,"user_access_code"=>$user_access_code, "date"=>$date,"time"=>$time);

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
                              'multiple_location_key'=>$multipleLocationKey
                             ];

     AlertDetails::saveDataAlertDetails($alertDetails);      

    return Response::json(array(
                     'error' => false,
                     'message' => "Video was successfully uploaded"),  
                     200
        ); 
        
                                    
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
                     'message' => "No user data found"),  
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
                     'message' => "Details was successfully saved"),  
                     200
              ); 

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
        $updated_date = date('Y-m-d h:i:s');

        $event_id = Input::get("eventid");
        $tds = date('Y-m-d h:i:s');
        $speed = Input::get("speed");
        $elevation = Input::get("elevation");
        $direction = Input::get("direction");
        $battery_level = Input::get("batterylevel");



        Log::debug($deviceID . ' ' . $lat . ' ' . $lon);

        $users = Users::where('fldUsersAccessCode','=',$deviceID)
                        ->first();

        if(count($users) == 0) {
            return Response::json(array(
                     'error' => true,
                     'message' => "Invalid Access Code"),  
                     200
            );
        }

      
        $auth_level = $users->fldUserStatus;
       
        $url = FIREBASE_PATH.'user_location.json';
                $arr = array($deviceID =>array("auth_level"=>$auth_level, "client_id"=>$users->fldUserID, "lat"=>$lat, "lon" =>$lon, "location_now"=>$location,"online_status"=>$online_status,"updated_date"=>$updated_date,"user_access_code"=>$deviceID, "event_id"=>$event_id, "tds"=>$tds, "speed" => $speed, "elevation" => $elevation, "direction" => $direction, "battery_level"=>$battery_level));  
                
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
           $arr = array("auth_level"=>$auth_level, "client_id"=>$users->fldUserID, "lat"=>$lat, "lon" =>$lon, "location_now"=>$location,"online_status"=>$online_status,"updated_date"=>$updated_date,"user_access_code"=>$deviceID, "event_id"=>$event_id, "tds"=>$tds, "speed" => $speed, "elevation" => $elevation, "direction" => $direction, "battery_level"=>$battery_level);

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

    public function videoStream() {
    	return View::make('stream.stream');
    }


    public function checkAccessCode() {
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
         //check the last event no
            $alertDetails = AlertDetails::where('user_code','=',$accesscode)
                                        ->where('location_now','!=','')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->first();
            if(count($alertDetails) == 0) {
              $lasteventID = 1;
            } else {                           
              $lasteventID = $alertDetails->events + 1;                            
            }

    		//generate users information to users
    		//$userRec = Users::generateUserFirebase($users);



    		return Response::json(array(
                     'error' => true,
                     'userInfo'=>$users->toArray(),
                     'lasteventID'=>$lasteventID,
                     'message' => "Access code is valid"),  
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
              $lasteventID = $alertDetails->events + 1;                            
            }

            //generate users information to users
            if($users->fldUserFirebaseKey == "") {
                $userRec = Users::generateUserFirebase($users,$lasteventID);
                $userKey = json_decode($userRec);
           

                $users->fldUserFirebaseKey = $userKey->name;
                
            }

            $users->fldUserMultipleLocationKey = str_random(20);
            $users->save();

           

            return Response::json(array(
                     'error' => true,
                     'userInfo'=>$users->toArray(),
                     'lasteventID'=>$lasteventID,
                     'message' => "Access code is valid"),  
                     200
            );
        }   
    }

    public function stopStreaming() {
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

            $userRec = Users::removeUserFirebase($users);

            $users->fldUserFirebaseKey = "";
            $users->save();

            return Response::json(array(
                     'error' => true,
                     'userInfo'=>$users->toArray(),
                     'message' => "Stop Streaming successfull"),  
                     200
            );
        }
    }

    
   

   
}
