<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class AlertDetails extends Eloquent
{
    protected $table = 'alert_detail';
    protected $primaryKey = 'alert_detail_id';
    public $timestamps = false;

    public static function  checkClientLocation() {
    	$location = self::where('status','=',0)
    					->where('client_id','=',Session::get('users_id'))
    					->where('location_now','!=',"")
    					->orderBy('alert_datetime','DESC')
    					->where('filePath','!=',"")
    					->limit(1)
    					->count();
    	return $location;
    }

    public static function  checkClientData($status) {
    	$location = self::where('status','=',$status)
    					->where('client_id','=',Session::get('users_id'))
    					->where('location_now','!=',"")
    					->orderBy('alert_datetime','DESC')
    					->where('filePath','!=',"")
    					->limit(1)
    					->first();
    	return $location;
    }

    public static function checkInOff() {
    	$location = self::where('status','=',1)
    					->where('client_id','=',Session::get('users_id'))
    					->where('location_now','!=','')
    					->orderBy('alert_datetime','DESC')
    					->where('filePath','!=',"")
    					->limit(1)
    					->count();



    	return $location;
    }

    public static function displayEvents($user_id) {

    	$events = self::where('user_id','=',$user_id)
    				  ->where('location_now','!=','')
    				  ->where('filePath','!=','')
    				  ->groupBy('events')
    				  ->orderBy('events')
    				  ->get();

    	$tuevent = array();
    	foreach($events as $event) {
    		$tuevent[] = $event;
    	}

		return $tuevent;



    }

    public static function displayVideos($user_id) {
    	$videos = self::where('user_id','=',$user_id)
    				  ->where('location_now','!=','')
    				  ->where('fileType','=','video')
    				  ->where('filePath','!=','')
    				  ->groupBy('alert_datetime')
    				  ->orderBy('alert_datetime')
    				  ->get();
    	return $videos;

    }

    public static function displayUsers($client_id,$status) {

    	$users = self::where('status','=',$status)
    				 ->where('client_id','=',$client_id)
    				 ->where('location_now','!=','')
    				 ->where('filePath','!=','')
    				 ->groupBy('user_id')
    				 ->orderBy('alert_datetime','DESC')
    				 ->get();

    	return $users;
    }

    public static function displayClientStatus($client_id,$status) {
    	$clients = self::where('client_id','=',$client_id)
    				   ->where('status','=',$status)
    				   ->groupBy('user_id')
    				   ->orderBy('alert_detail_id','DESC')
    				   ->get();

    	return $clients;
    }



    public static function saveDataAlertDetails($alertData) {


        //check if alert details already exists
        $alertCheck = self::where('user_code','=',$alertData->user_code)
                        ->where('events','=',$alertData->event_id)
                        ->first();

        if(count($alertCheck) == 0) {
            $alertDetails = new self;
        } else {
            $alertDetails = self::where('user_code','=',$alertData->user_code)
                        ->where('events','=',$alertData->event_id)
                        ->first();
        }


    		$alertDetails->user_id = $alertData->user_id;
    		$alertDetails->user_name = $alertData->user_name;
    		$alertDetails->alert_datetime = $alertData->alert_datetime;
    		$alertDetails->events = $alertData->event_id;
    		$alertDetails->status = $alertData->status;
    		$alertDetails->client_id = $alertData->client_id;
    		$alertDetails->lat = $alertData->lat;
    		$alertDetails->lng = $alertData->lng;
    		$alertDetails->location_now = $alertData->location_now;
    		//$alertDetails->address = $address;
    		$alertDetails->alert_battery_level = $alertData->alert_battery_level;
    		$alertDetails->alert_speed = $alertData->alert_speed;
    		$alertDetails->direction = $alertData->direction;
    		$alertDetails->elevation = $alertData->elevation;
    		$alertDetails->course = $alertData->course;
    		$alertDetails->level = $alertData->level;
    		//$alertDetails->accelerometer = $accelerometer;
    		$alertDetails->accel = $alertData->accel;
    		$alertDetails->filePath = $alertData->filePath;
    		$alertDetails->fileType = $alertData->fileType;
    		$alertDetails->user_code = $alertData->user_code;
            $alertDetails->multiple_location_key = $alertData->multiple_location_key;
        $alertDetails->floor = $alertData->floor;
        $alertDetails->distance = $alertData->distance;
        $alertDetails->distanceType = $alertData->distanceType;

        $path = public_path('videos/'.$alertData->filePath);
        try {
           $alertDetails->video_file_size = File::size($path);
        } catch(\Exception $e) {

        }
        
    	$alertDetails->save();

    }

    public static function displayAllFeeds($user_id,$event_id) {

    	if ($event_id == "") {
    		$allFeeds = self::where('user_id','=',$user_id)
    		                ->where('location_now','!=','')
    		                ->where('filePath','!=','')
    		                ->get();
    	} else {
    		$allFeeds = self::where('user_id','=',$user_id)
    		                ->where('location_now','!=','')
    		                ->where('filePath','!=','')
    		                ->where('events','=',$event_id)
    		                ->get();
    	}
    	//print_r($allFeeds);die();

    	$tuallfeeds = array();
    	foreach($allFeeds as $allFeed) {
    		$tuallfeeds[] = array(
				'alert_detail_id' => $allFeed->alert_detail_id,
				'events' => $allFeed->events,
				'alert_datetime' => $allFeed->alert_datetime,
				'user_id' => $allFeed->user_id,
				'user_code' => $allFeed->user_code,
				'status' => $allFeed->status,
				'client_id' => $allFeed->client_id,
				'user_name' => $allFeed->user_name,
				'lat' => (floatval($allFeed->lat)),
				'lng' => (floatval($allFeed->lng)),
				'alert_type' => $allFeed->alert_type,
				'location_now' => $allFeed->location_now,
				'filePath' => $allFeed->filePath,
				'fileType' => $allFeed->fileType,
				'alert_battery_level' => $allFeed->alert_battery_level,
				'alert_speed' => $allFeed->alert_speed,
				'alert_gps_files' => $allFeed->alert_gps_files,
				'alert_media_files' => $allFeed->alert_media_files,
				'direction' => $allFeed->direction,
				'elevation' => $allFeed->elevation,
				'device_token' => $allFeed->device_token
			);
    	}

    	return $tuallfeeds;

    }


    public static function deleteAlertDetails($accesscode) {



        $alertDetails = self::where('user_code','=',$accesscode)
                            ->get();

        foreach($alertDetails as $alertDetail) {
            if($alertDetail->filePath != "") {
              $filename = $accesscode.'-'.$alertDetail->events.'.flv';
              $videoPath = "/var/www/html/glasses/public/videos/".$filename;
              if(File::exists($videoPath)) {
                Log::debug("Unlink " . $videoPath);
                unlink($videoPath);
              } else {
                Log::debug("File not found " . $videoPath);
              }
            }

            $alertDetail->delete();
        }
    }



}
