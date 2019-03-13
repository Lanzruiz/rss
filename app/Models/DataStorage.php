<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File;
use Input;
use Hash;
use Validator;
use Session;
use Log;

class DataStorage extends Eloquent
{
  protected $table = 'tblAdministrator';
  protected $primaryKey = 'fldAdministratorID';
  public $timestamps = false;



  public static function CountVideoDataStorage($userID) {


    $totalfilesize = AlertDetails::where('user_id','=',$userID)
                                     ->groupBy('events')
                                     ->orderBy('events','DESC')
                                     ->sum('feeds_filesize');
      
      return $totalfilesize;
      
      //print_r($alertDetail);
      //$totalfilesize = 0;
      //foreach($alertDetail as $alertDetails) {
         //$filename = $alertDetails->filePath;
        //  $filesize = $alertDetails->feeds_filesize;
          
//         $path = public_path('videos/'.$filename);
//          $filesize=0;
//          //$path = "https://s3-us-west-2.amazonaws.com/raptor-security-software/videos/".$filename;
//         try {
//            $filesize = File::size($path);
//         } catch(\Exception $e) {
//             //Log::info(print_r($e, true));
//         }

         //$totalfilesize = $totalfilesize + $filesize;
     // }
      
      

  }
    
    
    
    private static function CheckSubscription($user_id, $convertGB, $convertMB) {
        if($convertMB >= 30) { //30 
            //check if user have existing subscription
            $subscription = Subscription::where('user_id','=',$user_id)
            ->orderBy('subscription_date','DESC')
            ->first();
            
            if($subscription) {
                $date_end = $subscription->subscription_date;
                if(date('Y-m-d') > $date_end) {
                    //subscription was expired
                    $response_obj = new \stdClass();
                    $response_obj->message = "Your subscription was expired.";
                    $response_obj->data_usage = $convertGB;
                    $response_obj->data_usage_in_mb = $convertMB;
                    $response_obj->error = true;
                    $response_obj->upgrade_account = true;
                    return $response_obj;
                } else {
                    $dataSize = $subscription->subscription_size + 1;
                    if($convertGB >= $dataSize) {
                        $response_obj = new \stdClass();
                        $response_obj->message = "Your data has exceeded.";
                        $response_obj->data_usage = $convertGB;
                        $response_obj->data_usage_in_mb = $convertMB;
                        $response_obj->error = true;
                        $response_obj->upgrade_account = true;
                        return $response_obj;
                    }
                }
            } else {
                $response_obj = new \stdClass();
                $response_obj->message = "Your data has exceeded.";
                $response_obj->data_usage = $convertGB;
                $response_obj->data_usage_in_mb = $convertMB;
                $response_obj->error = true;
                $response_obj->upgrade_account = true;
                return $response_obj;
            }
            
        } else {
            $response_obj = new \stdClass();
            $response_obj->message = "continue.";
            $response_obj->data_usage = $convertGB;
            $response_obj->data_usage_in_mb = $convertMB;
            $response_obj->error = false;
            $response_obj->upgrade_account = false;
            return $response_obj;
        }
        
        
    }
    
    
    public static function CheckDataStorageByCommander($commander_id,$current_filesize=0) {
        $listUsers = Users::where('fldUserLevel','!=','commander')
                            ->where('fldUsersCommanderID','=',$commander_id)
                            ->get();
        
        $convertGB = 0;
        $convertMB = 0;
        $videosize = 0;
        foreach($listUsers as $listUser) {
            
            $videosize = self::CountVideoDataStorage($listUser->fldUserID);
            $convertKB = $videosize * 0.001;
            $convertMB = $convertKB * 0.001;
            $convertGB = $convertGB + ($convertMB * 0.001);
            
            
        }
        
        Log::debug("CheckDataStorageByCommander");
        Log::debug("Bytes: ".$videosize);
        Log::debug("convertKB: ".$convertKB);
        Log::debug("convertMB: ".$convertMB);
        Log::debug("convertGB: ".$convertGB);
        
        //die();
        $convertMB = $convertMB + $current_filesize;
        $convertGB = $convertGB + ($current_filesize * 0.001);
        
        Log::debug("Data Usage with current feeds");
        Log::debug("MB: ".$current_filesize);
        Log::debug("convertMB: ".$convertMB);
        Log::debug("convertGB: ".$convertGB);
        
        $response = self::CheckSubscription($commander_id,$convertGB, $convertMB);
        return $response;
        
        
    }




}
