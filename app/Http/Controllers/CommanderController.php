<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;


use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Mail;
use Hash;

class CommanderController extends Controller {

  public function index() {
      $level = "commander";
      $users = Users::where('fldUserLevel','=',$level)->get();
      return View::make('admin.commander.index',compact('users'));
  }

  public function DislayAllUsers($id) {
      $commander = Users::find($id);
      if(count($commander) == 0) {
         Session:has('error','Commander not found');
         return redirect::to('admin/commander');
      } else {
         $users = Users::where('fldUsersCommanderID','=',$id)->get();
         return View::make('admin.commander.users',compact('users','id','commander'));
      }
  }

  public function CleanAllFeeds() {
      $level = "commander";
      $commander = Users::where('fldUserLevel','=',$level)->get();



      foreach($commander as $commanders) {
            $allUser = Users::where('fldUsersCommanderID','=',$commanders->fldUsersID)
                                    ->get();

          foreach($allUser as $allUsers) {
                  $accesscode = $allUsers->fldUsersAccessCode;

                  //echo $accesscode . ' <br>';
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

          } //all users agent and trans

      } //all commander


      Session::flash('success','Congratulations all feeds are removed & RealTime data is activated.');
      return redirect::to('/admin/commander');

  }


  public function CleanAllFeedsByCommanderID($commanderID) {
       $commander = Users::find($commanderID);
       if(count($commander) == 0) {
            Session::flash('error','Commander ID not found.');
            return redirect::to('/admin/commander');
       } else {
            $allUser = Users::where('fldUsersCommanderID','=',$commanderID)
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

            } //all users agent and trans


            Session::flash('success','Congratulations all feeds are removed & RealTime data is activated.');
            return redirect::to('/admin/commander/users/'.$commanderID);


       }
  }


  public function CleanAllFeedsByUserID($id) {
     $user = Users::find($id);

     if(count($user) == 0) {
       Session::flash('error','User ID not found.');
       return redirect::to('/admin/commander');
     } else {
           if($user->fldUsersCommanderID != "") {
               $accesscode = $user->fldUsersAccessCode;

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


           Session::flash('success','Congratulations all feeds are removed & RealTime data is activated.');
           return redirect::to('/admin/commander/users/'.$user->fldUsersCommanderID);

     }
  }



}
