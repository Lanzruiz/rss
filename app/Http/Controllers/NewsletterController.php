<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\Administrator;
use App\Models\Newsletter;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Request;


class NewsletterController extends Controller
{

  public function __construct()
   {
      //check if admin login
      //$this->middleware(function ($request, $next) {
            if(!Session::has('administrator_id')) {
                return Redirect::to('admin');
            } else {
                $administrator = Administrator::where('fldAdministratorID','=',Session::get('administrator_id'))->first();
                View::share(compact('administrator'));

                //return $next($request);
            }
        //});
   }



         public function index() {
           //if(!Session::has('administrator_id')) { return Redirect::to('/admin');}
           $newsletter = Newsletter::all();
           return View::make('admin.newsletter.index',compact('newsletter'));
         }


         public function create() {
           return View::make('admin.newsletter.add');
         }

         public function store() {
           $rules   = Newsletter::rules();
           $validator = Validator::make(Request::all(), $rules);

            if ($validator->fails()) {
                  return Redirect::to('admin/newsletter/create')->withInput()->withErrors($validator,'newsletter');
            } else {
               Newsletter::AddUpdateNewsletter(0);
               Session::flash('success','Newsletter was successfully saved');
               //return Redirect::to(Config::get('Constants.ADMIN_URL').'administrator/create');
               return Redirect::to('admin/newsletter');
            }
         }

         public function edit($id) {
            $newsletter = Newsletter::find($id);
            if($newsletter) {
                return View::make('admin.newsletter.edit',compact('newsletter'));
            } else {
              Session::flash('error','Newsletter not found');
              return Redirect::to('admin/newsletter');
            }
         }


         public function update($id) {

           $newsletter = Newsletter::find($id);
           if($newsletter) {
               $rules   = Newsletter::rules();
               $validator = Validator::make(Request::all(), $rules);

                if ($validator->fails()) {
                      return Redirect::to('admin/newsletter/'.$id.'/edit')->withInput()->withErrors($validator,'newsletter');
                } else {
                   Newsletter::AddUpdateNewsletter($id);
                   Session::flash('success','Newsletter was successfully saved');
                   //return Redirect::to(Config::get('Constants.ADMIN_URL').'administrator/create');
                   return Redirect::to('admin/newsletter');
                }
            } else {
              Session::flash('error','Newsletter not found');
              return Redirect::to('admin/newsletter');
            }
         }


         public function destroy($id) {
            $newsletter = Newsletter::find($id);

            if($newsletter) {
              $newsletter->delete();
              Session::flash('success','Newsletter was successfully deleted');
              return Redirect::to('admin/newsletter');
            } else {
              Session::flash('error','Newsletter not found');
              return Redirect::to('admin/newsletter');
            }
         }


         public function DisplayNewsletter($id) {
           $newsletter = Newsletter::find($id);

           if($newsletter) {
                return View::make('admin.newsletter.display',compact('newsletter'));
           } else {
             Session::flash('error','Newsletter not found');
             return Redirect::to('admin/newsletter');
           }
         }

         public function SendNewsletter($id) {
           $newsletter = Newsletter::find($id);

           if($newsletter) {
                $to = Input::get('to');
                $from = Input::get('from');
                $subject = Input::get('subject');
                $message = $newsletter->fldNewsletterDescription;

                if($to == "all") {
                  $user = Users::all();
                } else if($to == "commander") {
                  $user = Users::where('fldUserLevel','=','commander')->get();
                } else if($to == "agent") {
                  $user = Users::where('fldUserLevel','=','agent')->get();
                } else if($to == "transport") {
                  $user = Users::where('fldUserLevel','=','transport')->get();
                }

                foreach($user as $users) {
                  $email = $users->fldUsersEmail;
                  if($email != "") {
                     //send email adddress
                     try {

                      if($email == "ebmarcilla@gmail.com") {
                        $memberData = array('messages'=>$message);
                        $toName = $users->fldUsersFullname;
                        Mail::send('dashboard.emails.email', $memberData, function ($message) use ($email,$toName,$subject,$from) {
                            $message->from($from,PRODUCT_TITLE);
                            $message->to($to,$toName)->subject(PRODUCT_TITLE." ".$subject);
                            //$message->bcc(BCC);
                        });
                      }


                     } catch(\Exception $e) {
                       echo "email not sent";
                     }
                  }
                }

                Session::flash('success','Email was successfully sent');
                return Redirect::to('admin/newsletter');

           } else {
             Session::flash('error','Newsletter not found');
             return Redirect::to('admin/newsletter');
           }
         }




}
