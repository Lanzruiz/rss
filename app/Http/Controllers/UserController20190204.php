<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\Country;
use App\Models\Subscription;
use App\Models\DataStorage;
use App\Models\SessionData;
    use App\Models\Paypal;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Mail;
use Hash;
use Storage;
use Auth;


class UserController extends Controller
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

  public function registration()
  {
     //if(!Session::has('administratorID')) { return Redirect::to('/superuser');}
    if(Session::has('username')) {
       Session::reflash();
    }

     $country = Country::DisplayCountry();
     return View::make('front.registration',compact('country'));
  }

  public function downloadAPK() {
    return View::make('front.download');
  }

  public function downloadIPA() {
    return View::make('front.download_wesee');
  }

  public function saveRegistration() {
     $rules   = Users::rules(0);
     $validator = Validator::make(Input::all(), $rules);

     if ($validator->fails()) {
           return Redirect::to('registration')->withInput()->withErrors($validator,'users');
     } else {
         $users = Users::AddUpdateUser(0);
         /*
         $type = "Registration Subscription";
         $amount = 19.99;
         //redirect to paypal subscription page
         $p = new Paypal;
         $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
         //$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
         //$p->add_field('business','emmanuel@tbldevs.com');
         $p->add_field('business','Shawn@witnessone.com');
         $p->add_field('return',url('thankyou/payment/paypal'));
         $p->add_field('cancel_return',url('thankyou/declined/paypal'));
         $p->add_field('item_name',$type);
         $p->add_field('first_name',$users->fldUsersFullname);
         $p->add_field('last_name','');
         $p->add_field('amount',$amount);
         $p->add_field('curreny_code','USD');
         $p->add_field('receiver_email','Shawn@witnessone.com');
         //$p->add_field('receiver_email','emmanuel@tbldevs.com');
         $p->add_field('image_url',url('public/assets/images/main-logo.png'));
         $p->add_field('custom',$users->fldUserID);
         $p->submit_paypal_post();
          */
         
         Session::flash('username',Input::get('username'));
        Session::flash('password',Input::get('password'));
        Session::flash('success',"User was successfully saved.");
        return Redirect::to('registration');
    }
  }

  public function faq()
  {
     return View::make('front.faq');
  }

  public function login()
  {
     return View::make('front.index');
  }

  public function checkAccess() {
     $rules   = Users::login();
     $validator = Validator::make(Input::all(), $rules);

     if ($validator->fails()) {
           return Redirect::to('/')->withInput()->withErrors($validator,'users');
     } else {
        $user = Users::userLogin();

        if($user==true) {

          //check user login
          self::checkUserLogin();

          //redirect to dashboard
          //Session::flash('error',"Redirect to dashboard.");
          $users = Users::find($this->user_id);

          //check if remember_me is checked
          $year = time() + 3153336000;
          if(Input::get('remember')) {
            setcookie('remember_me', Input::get('username'), $year);
            setcookie('remember_ps',Input::get('password'), $year);
          } else {
              if(isset($_COOKIE['remember_me'])) {
                $past = time() - 100;
                setcookie('remember_me', 'gone', $past);
                setcookie('remember_ps', 'gone', $past);
              }
          }


            //************check  user data usage**************/
        $listUsers = Users::where('fldUserLevel','!=','commander')
                            ->where('fldUsersCommanderID','=',$this->user_id)
                            ->get();


        if(count($listUsers) >0) {
          $totalStorage = 0;
          $total_data_usage = 0;
          foreach($listUsers as $listUserss) {


          }

          //covert data usage to MB and GB
          $convertMB = $total_data_usage * 0.001;
          $convertGB = $convertMB * 0.001;



          if($convertGB > 1) {
             //check if user have existing subscription
             $subscription = Subscription::where('user_id','=',$this->customer_id)
                                        ->orderBy('subscription_date','DESC')
                                        ->first();

              if($subscription) {
                  $date_end = $subscription->subscription_date;
                  if(date('Y-m-d') > $date_end) {
                      //subscription was expired
                      Session::flash('error','Your subscription was expired.');
                      return Redirect::to('/subscription');
                  } else {
                     //check if subscription data size
                     //$dateFrom = date('Y-m-1');
                     //$dateTo = date('Y-m-d');
                     //check if user have multiple subscription
                     $dataSize = $subscription->subscription_size + 1;
                     if($convertGB >= $dataSize) {
                         //user data size exceeded redirect to subscription page
                         //Session::flash('error','Your data has exceeded.  You consumed ' . number_format($convertGB,2) . 'GB out of ' . $dataSize);
                         Session::flash('error','Your data has exceeded. ');
                         return Redirect::to('/subscription');
                     }
                  }
              } else {
                  //Session::flash('error','Your free data was exceeded. You consumed ' . number_format($convertGB,2) . 'GB out of 1GB');
                  Session::flash('error','Your data has exceeded.');
                  return Redirect::to('/subscription');
              }

          }


        }
        //************check  user data usage**************/


          if($users->fldUserSecurityCode == 1) {
            Session::put('security_code', $users->fldUserSecurityCode);
            return Redirect::to('/dashboard/console');

          } else {


               Session::put('security_code', $users->fldUserSecurityCode);
               return Redirect::to('/dashboard/console');



          }
        } else {

          Session::flash('error',"Invalid username or password.");
          return Redirect::to('/');
        }
    }
  }

  public function securityCode() {

    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }
    $user = true;
    return View::make('front.security',compact('users','user'));

  }

  public function checkSecurityCode() {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }
    $user = Users::checkSecurityCode();

    if($user == false) {
      Session::flash('error',"Invalid Security code.");
        return Redirect::to('/security_code');
    } else {
      return Redirect::to('/dashboard/console');
    }


  }

  public function console() {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }
    $consoleTitle = LIVECONSOLE;
    return View::make('dashboard.index',compact('users','consoleTitle'));
  }

  public function package() {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }

    return View::make('dashboard.subscription.index',compact('users'));
  }

  public function listUsers() {
      $users = self::checkUserLogin();
      if(!$users) {
         return Redirect::to('/');
      }

      $listTransport = Users::where('fldUserLevel','=','transport')
                            ->where('fldUsersCommanderID','=',$this->user_id)
                            ->get();

      $listAgent = Users::where('fldUserLevel','=','agent')
                            ->where('fldUsersCommanderID','=',$this->user_id)
                            ->get();


      $listUsers = Users::where('fldUserLevel','!=','commander')
                          ->where('fldUsersCommanderID','=',$this->user_id)
                          ->get();

      $consoleTitle = LIVECONSOLE;
      $country = Country::DisplayCountry();


      return View::make('dashboard.users.index',compact('users','listUsers','consoleTitle','listTransport','listAgent','country'));

  }

  public function addNewUsers() {
     $users = self::checkUserLogin();
     if(!$users) {
        return Redirect::to('/');
     }

     if(Input::get('userType') == 0) {
        $rules   = Users::rulesUser(0);

        // if(count(Input::get('agentID')) == 0) {
        //     Session::flash('agents','Please select your agent');
        //     return Redirect::to('dashboard/users')->withInput();
        // }

     } else {
        $rules   = Users::rulesUserAgent(0);
     }

       $validator = Validator::make(Input::all(), $rules);

       if ($validator->fails()) {
             return Redirect::to('dashboard/users')->withInput()->withErrors($validator,'users');
       } else {
         //echo Input::get('country_code');die();
        //check if username already in used
        $username = Input::get('username');
        $count_username = Users::where('fldUsersUserName','=',$username)->count();
        if($count_username == 1) {
            Session::flash('error',"Username is already used.");
           return Redirect::to('dashboard/users')->withInput();
        } else {
           Users::AddDashboardUser(0, $this->user_id);
          Session::flash('success',"User was successfully saved.");
          return Redirect::to('dashboard/users');
        }

      }
  }


  public function editUsers($id) {
      $users = self::checkUserLogin();
      if(!$users) {
         return Redirect::to('/');
      }


      $listUsers = Users::where('fldUserLevel','!=','commander')
                          ->where('fldUsersCommanderID','=',$this->user_id)
                          ->get();

      $listTransport = Users::where('fldUserLevel','=','transport')
                            ->where('fldUsersCommanderID','=',$this->user_id)
                            ->get();

    $listAgent = Users::where('fldUserLevel','=','agent')
                            ->where('fldUsersCommanderID','=',$this->user_id)
                            ->get();


      $currentUser = Users::find($id);

      if(count($currentUser) == 0) {
          return Redirect::to('dashboard/users');
      }

       $consoleTitle = LIVECONSOLE;
       $country = Country::DisplayCountry();
      return View::make('dashboard.users.edit',compact('users','currentUser','listUsers','consoleTitle','listTransport','listAgent','country'));
  }

  public function updateUsers($id) {
      $users = self::checkUserLogin();
      if(!$users) {
         return Redirect::to('/');
      }

       if(Input::get('userType') == 0) {
          $rules   = Users::rulesUser($id);

          if(count(Input::get('agentID')) == 0) {
              Session::flash('agents','Please select your agent');
              return Redirect::to('dashboard/users/edit/'.$id)->withInput();
          }

       } else {
          $rules   = Users::rulesUserAgent($id);
       }

       $validator = Validator::make(Input::all(), $rules);

       if ($validator->fails()) {
             return Redirect::to('dashboard/users/edit/'.$id)->withInput()->withErrors($validator,'users');
       } else {
           $username = Input::get('username');
          $count_username = Users::where('fldUsersUserName','=',$username)->where('fldUserID','!=',$id)->count();
          if($count_username == 1) {
             Session::flash('error',"Username is already used.");
            return Redirect::to('dashboard/users/edit/'.$id)->withInput();
          } else {

             Users::AddDashboardUser($id);
             Session::flash('success',"User was successfully updated.");
            return Redirect::to('dashboard/users/edit/'.$id);
          }


      }
  }

  public function deleteUsers($id) {
      $users = self::checkUserLogin();
      if(!$users) {
         return Redirect::to('/');
      }

      $user = Users::find($id);





      if(count($user) == 0) {
          return Redirect::to('dashboard/users');
      }


      $accesscode = $user->fldUsersAccessCode;


      if($user->fldUsersCommanderID != "") {
         Users::deleteMultipleLocationFirebase($accesscode);
         Users::deleteUserLocationFirebase($accesscode);
         Users::deleteVideoData($accesscode);
         Users::removeUserFirebase($user);

          Users::removeUserRemoteControl($user);
         Users::removeActiveUser($user);

         AlertDetails::deleteAlertDetails($accesscode);
      }

      $user->delete();
      return Redirect::to('dashboard/users');
  }


  public function cleanUserFeeds($id) {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }

    $user = Users::find($id);


    if(count($user) == 0) {
        return Redirect::to('dashboard/users');
    }


    $accesscode = $user->fldUsersAccessCode;


    if($user->fldUsersCommanderID != "") {
       Users::deleteMultipleLocationFirebase($accesscode);
       Users::deleteUserLocationFirebase($accesscode);
       Users::deleteVideoData($accesscode);
       Users::removeUserFirebase($user);
       AlertDetails::deleteAlertDetails($accesscode);
    }

      $user->fldUserFirebaseKey = "";
      $user->fldUserMultipleLocationKey = "";
      $user->fldUsersNextEvent = 0;
    $user->save();

    Session::flash('clean_success',"User feeds was successfully cleaned. ");
    return Redirect::to('dashboard/users');
  }

  public function profile() {
      $users = self::checkUserLogin();
      if(!$users) {
         return Redirect::to('/');
      }
      $consoleTitle = LIVECONSOLE;
      $country = Country::DisplayCountry();
      return View::make('dashboard.profile',compact('users','consoleTitle','country'));
  }

  public function updateProfile() {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }

       $rules   = Users::rules($this->user_id);
       $validator = Validator::make(Input::all(), $rules);

       if ($validator->fails()) {
             return Redirect::to('dashboard/profile')->withInput()->withErrors($validator,'users');
       } else {
           Users::AddUpdateUser($this->user_id);
          Session::flash('success',"Profile was successfully updated.");
          return Redirect::to('dashboard/profile');
      }


  }

  public function displayArchive() {
       $users = self::checkUserLogin();
       if(!$users) {
          return Redirect::to('/');
       }


       $agent = Users::where('fldUsersCommanderID','=',$this->user_id)
                      ->where('fldUserLevel','=','agent')
                      ->get();

       $transport = Users::where('fldUsersCommanderID','=',$this->user_id)
                      ->where('fldUserLevel','=','transport')
                      ->get();

      $alertDetails = AlertDetails::checkClientLocation();
      $alertInOff = AlertDetails::checkInOff();

      //echo $alertDetails .  ' ' . $alertInOff;die();

      if($alertDetails < 1 && $alertInOff < 1) {
          return Redirect::to('dashboard/error');
      }


       $checkClientData = AlertDetails::checkClientData(0);
        if(count($checkClientData) > 0) {
           $events = AlertDetails::displayEvents($checkClientData->user_id);
           $videos = AlertDetails::displayVideos($checkClientData->user_id);
           $displayAllFeeds = AlertDetails::displayAllFeeds($checkClientData->user_id,$checkClientData->events);
       } else {
          $events = (object)[];
          $videos = (object)[];
       }
       $usersAlert = AlertDetails::displayUsers($this->user_id,0);
       $displayAlertDetail = AlertDetails::displayClientStatus($this->user_id,1);
       $client_id = $this->user_id;
      $consoleTitle = ARCHIVEDCONSOLE;


      $selectAgent = "";
      $selectTrans = "";
      if(Session::has('alert_detail_id')) {
            $alertDetail = AlertDetails::find(Session::get('alert_detail_id'));
            //print_r($alertDetail);die();
            if(count($alertDetail) == 1) {
                if(Session::has('alert_detail_user_type')) {
                    if(Session::get('alert_detail_user_type') == 'agent') {
                        $selectAgent = $alertDetail->user_id;
                    } else if(Session::get('alert_detail_user_type') == 'transport') {
                        $selectTrans = $alertDetail->user_id;
                    }
                }
            }

            //echo $selectTrans;die();

      }


      return View::make('dashboard.archieve',compact('users','consoleTitle','agent','transport','alertDetails','alertInOff','checkClientData',
                                                    'events','videos','usersAlert','displayAlertDetail','displayAllFeeds','client_id','selectAgent','selectTrans'));

  }

  public function displayError() {
     return View::make('dashboard.error');
  }

  public function logout() {

      Session::flush();
      Session::save();

      $session_data = SessionData::find(Session::getId());
      if($session_data) {
        $session_data->delete();
      }
      return Redirect::to('/');
      //return Redirect::to('dashboard/profile');
  }

  public function tRecords() {
      $lastid = Input::get('last_id');
      $user_id = Input::get('user_id');
      $tEvent = Input::get('tEvent');
      $status = Input::get('status');

      if($status == "video") {
           if($lastid == ''){
              $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                        ->where('events','=',$tEvent)
                                        ->where('fileType','=','video')
                                        ->groupBy('alert_datetime')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->limit(5)
                                        ->get();
           } else {
              $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                        ->where('events','=',$tEvent)
                                        ->where('fileType','=','video')
                                        ->groupBy('alert_datetime')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->where('alert_detail_id','<',$lastid)
                                        ->limit(5)
                                        ->get();
           }

           if(count($alertDetail) < 1) {
              echo 'NoMoreVideo';
          } else {
              //  $data = array();
              // foreach($alertDetail as $alertDetails) {
              //     $data[] = $alertDetail;
              // }
              echo json_encode($alertDetail);
          }

      } else if($status == "events") {
          if($lastid == '') {
                  $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                              ->groupBy('events')
                                              ->orderBy('events','DESC')
                                              ->limit(5)
                                              ->get();
          } else {
              $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                              ->groupBy('events')
                                              ->orderBy('events','DESC')
                                              ->where('alert_detail_id','<',$lastid)
                                              ->limit(5)
                                              ->get();
          }

          if(count($alertDetail) < 1) {
              echo 'NoMoreEvent';
          } else {
              // $data = array();
              // foreach($alertDetail as $alertDetails) {
              //     $data[] = $alertDetails;
              // }
              echo json_encode($alertDetail);
          }
      } else if ($status == "eventVideo") {

          $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                      ->where('events','=',$tEvent)
                                      ->where('fileType','=','video')
                                      ->orderBy('alert_detail_id','DESC')
                                      ->limit(5)
                                      ->get();
          if(count($alertDetail) < 1) {
              echo 'NoVideoFound';
          }  else {
              //  $data = array();
              // foreach($alertDetail as $alertDetails) {
              //     $data[] = $alertDetails;

              // }
              echo json_encode($alertDetail);
          }


      } else if($status == "getVideo") {
         $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                 ->where('events','=',$tEvent)
                                 ->where('fileType','=','video')
                                 ->orderBy('alert_detail_id','DESC')
                                 ->first();
        if(count($alertDetail) < 1) {
          echo 'NoMoreVideo';
        } else {
          echo json_encode($alertDetail);
        }

      }


  }


  public function firstPIDCheck() {
      $client_id = Input::get('client_id');

      $alertDetail = AlertDetails::where('status','=',0)
                                 ->where('client_id','=',$client_id)
                                 ->where('location_now','!=','')
                                 ->where('filePath','!=','')
                                 ->orderBy('alert_datetime','DESC')
                                 ->first();
      if(count($alertDetail) > 0) {
          echo 'PidFound';
      } else {
         echo 'PidNoFound';
      }

  }

  public function firstOfficerCheck() {
      $client_id = Input::get('client_id');
      $alertDetail = AlertDetails::where('status','=',1)
                                 ->where('client_id','=',$client_id)
                                 ->where('location_now','!=','')
                                 ->where('filePath','!=','')
                                 ->groupBy('user_id')
                                 ->orderBy('alert_datetime','DESC')
                                 ->first();
       if(count($alertDetail) > 0) {
          echo 'OfficerFound';
      } else {
         echo 'OfficerNoFound';
      }
  }

  public function trAlertStatusFeed() {

    $action = Input::get('action');
    switch ($action) {
      case 'tu_alert_status':
        $GLOBAL_TUSER_ID = Input::get('GL_TUSER_ID');
        $GLOBAL_TUSER_EVENT = Input::get('GL_TU_EVENT_ID');
        $all_feed = AlertDetails::displayAllFeeds($GLOBAL_TUSER_ID,$GLOBAL_TUSER_EVENT);
        $tuser_feeds = array("all_feeds" => $all_feed);
        echo json_encode($tuser_feeds);
        break;

    }


  }
  public function actionAgAllFeed() {

    $action = Input::get('action');
    switch ($action) {
      case 'buserAllFeeds':
        $GLOBAL_BUSER_ID = Input::get('GL_BUSER_ID');
        $GLOBAL_BUSER_EVENT = Input::get('buserEventID');
        $agentAllFeeds = AlertDetails::displayAllFeeds($GLOBAL_BUSER_ID,$GLOBAL_BUSER_EVENT);
        $buserFeeds = array("agentAllFeeds" => $agentAllFeeds);
        echo json_encode($buserFeeds);
        break;


    }


  }
  public function bRecords() {
    $lastid = Input::get('last_id');
    $user_id = Input::get('user_id');
    $bEvent = Input::get('bEvent');
    $status = Input::get('status');

    if($status == 'video') {
        if($lastid == '') {
             $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                        ->where('events','=',$bEvent)
                                        ->where('fileType','=','video')
                                        ->groupBy('alert_datetime')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->limit(5)
                                        ->get();
        } else {
            $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                        ->where('events','=',$bEvent)
                                        ->where('fileType','=','video')
                                        ->where('alert_detail_id','<',$lastid)
                                        ->groupBy('alert_datetime')
                                        ->orderBy('alert_detail_id','DESC')
                                        ->limit(5)
                                        ->get();
        }

        if(count($alertDetail) < 1) {
            echo 'NoMoreVideo';
        } else {
          echo json_encode($alertDetail);
        }

    } else if($status == "eventVideo") {

      $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                 ->where('events','=',$bEvent)
                                 ->where('fileType','=','video')
                                 ->orderBy('alert_detail_id','DESC')
                                 ->limit(5)
                                 ->get();
      if(count($alertDetail) < 1) {
            echo 'NoVideoFound';
        } else {
          echo json_encode($alertDetail);
        }

    } else if($status == "events") {
        if($lastid == '') {
            $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                       ->groupBy('events')
                                       ->orderBy('events','DESC')
                                       ->limit(5)
                                       ->get();

        } else {
            $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                       ->where('alert_detail_id','<',$lastid)
                                       ->groupBy('events')
                                       ->orderBy('events','DESC')
                                       ->limit(5)
                                       ->get();
        }

        if(count($alertDetail) < 1) {
          echo 'NoMoreEvent';
        } else {
          echo json_encode($alertDetail);
        }
    } else if($status == "getVideo") {
         $alertDetail = AlertDetails::where('user_id','=',$user_id)
                                 ->where('events','=',$bEvent)
                                 ->where('fileType','=','video')
                                 ->orderBy('alert_detail_id','DESC')
                                 ->first();
        if(count($alertDetail) < 1) {
          echo 'NoMoreVideo';
        } else {
          echo json_encode($alertDetail);
        }

    }

  }


  public function displayEventsByUser() {
      $userID = Input::get('user_id');

      $alertDetail = AlertDetails::where('user_id','=',$userID)
                                       ->groupBy('events')
                                       ->orderBy('events','DESC')
                                       ->limit(5)
                                       ->get();
       if(count($alertDetail) < 1) {
          echo 'NoMoreEvent';
        } else {
          echo json_encode($alertDetail);
        }

  }

  public function displayVideoByUserEvents() {
      $userID = Input::get('user_id');
      $eventID = Input::get('event_id');



       $alertDetail = AlertDetails::where('user_id','=',$userID)
                                 ->where('events','=',$eventID)
                                 ->where('fileType','=','video')
                                 ->orderBy('alert_detail_id','DESC')
                                 ->limit(5)
                                 ->get();


      if(count($alertDetail) < 1) {
            echo 'NoVideoFound';
        } else {
          echo json_encode($alertDetail);
        }

  }


  public function UserMultipleLocationKey() {
     $eventID = Input::get('eventID');
     $accesscode = Input::get('accesscode');

       $alertDetail = AlertDetails::where('user_code','=',$accesscode)
                                ->where('events','=',$eventID)
                                ->first();

        if(count($alertDetail) < 1) {
            echo 'NoVideoFound';
        } else {
          echo $alertDetail->multiple_location_key;
        }


  }

  public function displayGlassMap($accesscode) {

       $user = Users::where('fldUsersAccessCode','=',$accesscode)
                    ->first();
      $error = "";
      $comanderID = 0;
      if(count($user) == 0) {
         $error = "Invalid access code";
      } else {
         $comanderID = $user->fldUsersCommanderID;
      }

      return View::make('map.maps',compact('error','comanderID','accesscode'));
  }


  public function displayGlassMapNew($accesscode) {

       $user = Users::where('fldUsersAccessCode','=',$accesscode)
                    ->first();
      $error = "";
      $comanderID = 0;
      if(count($user) == 0) {
         $error = "Invalid access code";
      } else {
         $comanderID = $user->fldUsersCommanderID;
      }

      return View::make('map.maps_new',compact('error','comanderID','accesscode'));
  }


  public function DeleteSelectedEvent($accesscode,$eventid) {

    $userEvent = AlertDetails::where('user_code','=',$accesscode)
                             ->where('events','=',$eventid)
                             ->first();

    if(count($userEvent) == 1) {
        $userEvent->delete();

        Users::deleteMultipleLocationFirebaseByEvent($accesscode,$eventid);
        Users::deleteVideoDataByEvents($accesscode,$eventid);


    }

    //check if there is no available events update the users event count to 0
    $userEventCount = AlertDetails::where('user_code','=',$accesscode)
                             ->count();
    if($userEventCount == 0) {
        //update the users value
        $users = Users::where('fldUsersAccessCode','=',$accesscode)->first();
        if(count($users) == 1) {
            $users->fldUsersNextEvent = 0;
            $users->save();
        }
    }

     //return Redirect::to('dashboard/archived');

  }


  public function displayUserByType() {
     $userType = Input::get('userType');
     $commanderID = Input::get('commanderID');

     $users = Users::where('fldUserStatus','=',$userType)
                   ->select('fldUserID','fldUsersFullname')
                   ->where('fldUsersCommanderID','=',$commanderID)
                   ->get();


        //$userInfo = array("agentAllFeeds" => $users);
        echo json_encode($users);

  }
  public static function getExistingFeed() {

      $curl = curl_init();
      $url = "https://smartglass-aed6d.firebaseio.com/remote_control.json";
      curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
          return false;
      } else {
          return $response;
      }

  }


  public static function scheduleFeedCleaning() {

      // Fetch All Commander
      $users = Users::where('isClear','=',1)
          // ->where('clear_date', '>=', date("Y-m-d H:i:s", strtotime("-1 minutes")))
          // ->where('clear_date', '<=', date("Y-m-d H:i:s", strtotime("+1 minutes")))
          ->limit(1)->get();
      echo "Total Users clear: ". $users->count();
      foreach($users as $user) {
      //     // Delete Firebase Data
          $url = FIREBASE_PATH.'audio_live_recording/'.$user->fldUsersCommanderID.'.json';
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          $result = curl_exec($ch);

          $accesscode = $user->fldUsersAccessCode;


          if($user->fldUsersCommanderID != "") {
              Users::deleteMultipleLocationFirebase($accesscode);
              Users::deleteUserLocationFirebase($accesscode);
              Users::deleteVideoData($accesscode);
              Users::removeUserFirebase($user);
              AlertDetails::deleteAlertDetails($accesscode);
              Users::removeUserRemoteControl($user);
              Users::removeActiveUser($user);

          }

          $user = Users::find($user->fldUserID);
          if(count($user) == 1) {
              $user->fldUserFirebaseKey = "";
              $user->fldUserMultipleLocationKey = "";
              $user->fldUsersNextEvent = 0;
              $user->save();
          }
          Users::where('fldUserID', $user->fldUserID)->update(
              [
                  'isClear' => 0
                  // 'clear_date' => date("Y-m-d H:i:s", time() + 86400)
                  // 'clear_date' => '0000-00-00 00:00:00'
              ]
          );
          // echo "<pre>";
          // var_dump( $url );
          // var_dump($user);
          // echo "</pre>";
          return json_encode($user);
      }
      echo "\nDone";

  }
  public static function TestAlvin() {
      $users = json_decode(static::getExistingFeed());

      date_default_timezone_set('Asia/Manila');
      // echo date("Y-m-d H:i:s") . "</br>";
      // echo date("Y-m-d H:i:s", strtotime("-2 hours")) . "</br>";
      return json_encode($users);//date("Y-m-d H:i:s", strtotime("+2 hours"));
  }
  public static function AddToCleanFirebaseQue() {
      /*
      * Clean PTT Feed
       - Check if existing feed exist
       - Clean if No feed is running


      * Clean All Feeds
      - Check if existing feeds exist per user
      - Clean if No feed is running
      */
      $users = Users::where('fldUserStatus','<',2)->get();
      $total_users = $users->count();
      $feed_data = json_decode(static::getExistingFeed());

      foreach($users as $user) {
          $userID = $user->fldUserID;
          $commanderID = $user->fldUsersCommanderID;
          $accessCode = $user->fldUsersAccessCode;
          $userStatus = $user->fldUserStatus; // 2 = Commander, 1 = Agent, 0 = Transport
          $status = '';
          $isClear = 1;

          if(isset( $feed_data->$commanderID ) ) {
              if(isset($feed_data->$commanderID->agent->$accessCode)) {
                  // var_dump($commanderID);
                  // var_dump($feed_data->$commanderID->agent );
                  $isClear = 0;
              }
              if(isset($feed_data->$commanderID->transport->$accessCode)) {
                  // var_dump($commanderID);
                  // var_dump($feed_data->$commanderID->transport );
                  $isClear = 0;
              }

          }
          if($isClear) {

              Users::where('fldUserID', $userID)->update(
                  [
                      'isClear' => 1,
                      'clear_date' => date("Y-m-d H:i:s", time() + 86400)
                      // 'clear_date' => date("Y-m-d H:i:s")
                  ]
              );

          }

      }

      return "All feed are set to be cleared.";
  }

  public function ClearPTTAudio() {
    $users = self::checkUserLogin();
    if(!$users) {
       return Redirect::to('/');
    }

    $userID = $this->user_id;
    $users = Users::find($this->user_id);

    if(count($users) == 1) {
      $url = FIREBASE_PATH.'audio_recording/'.$userID.'.json';


      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


      $result = curl_exec($ch);

    }
    Session::flash('success_clean_ptt','Congratulations all PTT feeds are removed & RealTime data is activated.');
    return Redirect::to('/dashboard/users');

  }


 public function ForgotPassword() {
    return View::make('front.forgot-password');
 }

 public function CheckForgotPassword() {
   $email = Input::get('email');

   //check users email if valid
   $userlevel = "commander";
   $checkEmail = Users::where('fldUsersEmail','=',$email)
                       ->where('fldUserLevel','=',$userlevel)
                       ->first();

     if(count($checkEmail) == 0) {
         Session::flash('error','Invalid email address');
         return Redirect::to('/forgot-password');
     } else {

        //save the reset security to DB
      $security = Session::getId();

      $checkEmail->fldUserSecurity = $security;
      $checkEmail->save();


        //if email is valid send email to user with links to reset the password
       $data = array('fullname' => $checkEmail->fldUsersFullname, 'security' => $security);

       Mail::send('front.emails.forgot-password', $data, function($message) use ($checkEmail) {

              $message->from("info@0321technologies.com",PRODUCT_TITLE);
              $message->to($checkEmail->fldUsersEmail,$checkEmail->fldUsersFullname)->subject(PRODUCT_TITLE." Forgot Password");
              $message->bcc(BCC);

       });


        Session::flash('success','success');
        return Redirect::to('/forgot-password');

     }


 }



 public function ResetPassword($security) {

      //search if security hash is valid
      $userSecurity = Users::where('fldUserSecurity','=',$security)->first();

      if(count($userSecurity) == 0) {
            Session::flash('error','Invalid security code');
            return Redirect::to('/');
      } else {
            return View::make('front.reset-password');
      }


 }


 public function SaveNewPassword($security) {

     //search if security hash is valid
      $userSecurity = Users::where('fldUserSecurity','=',$security)->first();

      if(count($userSecurity) == 0) {
            Session::flash('error','Invalid security code');
            return Redirect::to('/');
      } else {

            $password = Input::get('password');
            $password1 = Input::get('password1');

            //if password and confirm password is not identical return error message
            if($password != $password1)  {
                Session::flash('error','Password and confirm password is not identical');
                return Redirect::to('/new-password/'.$security);
            } else {
               //change the old password to new password
               $userSecurity->fldUsersPassword = Hash::make($password);
               //$userSecurity->fldUserSecurity = "";
               $userSecurity->save();


               //send confirmation email that password has been succesfuly changed
               $data = array('fullname' => $userSecurity->fldUsersFullname);

               Mail::send('front.emails.reset-password', $data, function($message) use ($userSecurity) {

                      $message->from("info@0321technologies.com",PRODUCT_TITLE);
                      $message->to($userSecurity->fldUsersEmail,$userSecurity->fldUsersFullname)->subject(PRODUCT_TITLE." Reset Password");
                      $message->bcc(BCC);

               });


               //redirect to login page
                Session::flash('reset-success','success');
                return Redirect::to('/');

            }


      }

 }


 public function UpdateEventName() {

      $eventTrans = Input::get('eventTrans');
      $eventTransID = Input::get('eventTransID');

      $alertDetails = AlertDetails::find($eventTransID);

      if(count($alertDetails) == 0) {

      } else {
         $alertDetails->event_name = $eventTrans;
         $alertDetails->save();
      }

      Session::flash('alert_detail_id',$eventTransID);
       Session::flash('alert_detail_user_type','transport');

     return Redirect::to('/dashboard/archived');
 }


 public function UpdateEventNameAgent() {
      $eventAgent = Input::get('eventAgent');
       $eventAgentID = Input::get('eventAgentID');

       $alertDetails = AlertDetails::find($eventAgentID);

       if(count($alertDetails) == 0) {

       } else {
          $alertDetails->event_name = $eventAgent;
          $alertDetails->save();
       }



       Session::flash('alert_detail_id',$eventAgentID);
       Session::flash('alert_detail_user_type','agent');

      return Redirect::to('/dashboard/archived');
 }


 public function CleanAllFeeds() {


        $users = self::checkUserLogin();
        if(!$users) {
           return Redirect::to('/');
        }

      $allUser = Users::where('fldUsersCommanderID','=',$this->user_id)
                              ->get();

      foreach($allUser as $allUsers) {
            $accesscode = $allUsers->fldUsersAccessCode;


            if($allUsers->fldUsersCommanderID != "") {
               Users::deleteMultipleLocationFirebase($accesscode);
               Users::deleteUserLocationFirebase($accesscode);
               Users::deleteVideoData($accesscode);
               Users::removeUserFirebase($allUsers);
               AlertDetails::deleteAlertDetails($accesscode);
               Users::removeUserRemoteControl($allUsers);
               Users::removeActiveUser($allUsers);

            }

            $user = Users::find($allUsers->fldUserID);
            if(count($user) == 1) {
              $user->fldUserFirebaseKey = "";
              $user->fldUserMultipleLocationKey = "";
              $user->fldUsersNextEvent = 0;
            $user->save();
          }

      }

      Session::flash('success_clean_ptt','Congratulations all feeds are removed & RealTime data is activated.');
      return Redirect::to('dashboard/users');

 }


 public function InviteFriends() {
    $access_code = Input::get('access_code');
    $user = Users::where('fldUsersAccessCode','=',$access_code)->first();
    $user_name = "";
    if($user) {
      $user_name = $user->fldUsersFullname;
    }
    //echo $access_code;
    $url = FIREBASE_PATH.'user_contacts/'.$access_code.'.json';
    //echo $url;die();
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


     $result = curl_exec($ch);

     $results = json_decode($result);

     if(count($results) > 0) {
       $messages = $user_name. " has invited you to use raptorsecuritysoftware. Use this <a href='https://raptorsecuritysoftware.us/'>link</a> to download the apps";

       foreach($results as $resultss) {
         //print_r($resultss->contact_no);
         if($resultss->contact_no != "") {
            //send sms invitation
            //Log::debug("send sms invitation: " . $resultss->contact_no);
            SMS::sendSMS($resultss->contact_no,$messages,0);
         }

        if($resultss->email != "") {
            //send email invitation

            //Log::debug("send email invitation: " . $resultss->email );
            $memberData = array('messages'=>$messages);
            $to = $resultss->email;
            $toName = $resultss->name;

            $subject = "Raptorsecuritysoftware Invitation";

            try {

              Mail::send('dashboard.emails.email', $memberData, function ($message) use ($to,$toName,$subject) {

                  $message->from(FROM_EMAIL,PRODUCT_TITLE);
                  $message->to($to,$toName)->subject(PRODUCT_TITLE." ".$subject);
                  $message->bcc(BCC);

              });

            } catch(\Exception $e) {
              return Response::json(array(
                       'error' => true,
                       'message' => "Invalid email address."),
                       200
              );
            }



         }

       }

       return Response::json(array(
                'error' => false,
                'message' => "success"),
                200
       );
     } else {
       return Response::json(array(
                'error' => true,
                'message' => "Your friend's information not found"),
                200
       );
     }


 }


 public function TestS3() {
   $s3 = App::make('aws')->createClient('s3');
    $s3->putObject(array(
        'Bucket'     => 'raptor-security-software',
        'Key'        => 'feeds',
        'SourceFile' => public_path('public/assets/images/accept.png'),
    ));
 }



}
