<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\Administrator;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;

class AdministratorController extends Controller
{

   public function index() {

   		  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

        $admin = Administrator::all();
       return View::make('admin.administrator.index',compact('admin'));
    }

    public function create() {
    	  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

       return View::make('admin.administrator.add');
    }

    public function store() {
    	  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

      $rules   = Administrator::rules();
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
            return Redirect::to('/admin/settings/create')->withInput()->withErrors($validator,'admin');
      } else {
          Administrator::SaveUpdateAdministrator(0);
          Session::flash('success','Administrator was successfully created.');
          return redirect::to('/admin/settings');
      }
    }

    public function edit($id) {
    	  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

      $admin = Administrator::find($id);
      if(count($admin) == 0) {
        Session::flash('error','Administrator id not found.');
        return redirect::to('/admin/settings');
      } else {
          return View::make('admin.administrator.edit',compact('admin'));
      }
    }

    public function update($id) {
    	  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

      $admin = Administrator::find($id);
      if(!$admin) {
        Session::flash('error','Administrator id not found.');
        return redirect::to('/admin/settings');
      } else {
        Administrator::SaveUpdateAdministrator($id);
        Session::flash('success','Administrator was successfully created.');
        return redirect::to('/admin/settings');
      }
    }

    public function destroy($id) {
    	  if(!Session::has('administrator_id')) { return Redirect::to('/admin');}

      $admin = Administrator::find($id);
      if(count($admin) == 0) {
        Session::flash('error','Administrator id not found.');
        return redirect::to('/admin/settings');
      } else {
        $admin->delete();
        Session::flash('success','Administrator was successfully deleted.');
        return redirect::to('/admin/settings');
      }
    }


    public function SuperUser()
    {
       return View::make('front.login');
    }

    public function CheckSuperUser() {
      $rules   = Administrator::login();
      $validator = Validator::make(Input::all(), $rules);

      if ($validator->fails()) {
            return Redirect::to('/superuser')->withInput()->withErrors($validator,'administrator');
      } else {
         $administrator = Administrator::adminLogin();

         if($administrator==true) {
            //redirect to registration page
            return Redirect::to('/registration');
         } else {
           Session::flash('error',"Invalid username or password.");
           //redirect to useruser
           return Redirect::to('/superuser');
         }
     }
   }

   public function TestStreaming() {
     return View::make('front.testing');
   }

   public function Login() {
     return View::make('admin.login');
   }

   public function CheckLogin() {
     $rules   = Administrator::rules();
     $validator = Validator::make(Input::all(), $rules);

     if ($validator->fails()) {
           return Redirect::to('/admin')->withInput()->withErrors($validator,'admin');
     } else {
        $administrator = Administrator::CheckLogin();

        if($administrator==true) {
           //redirect to registration page
           return Redirect::to('/admin/dashboard');
        } else {
          Session::flash('error',"Invalid username or password.");
          //redirect to useruser
          return Redirect::to('/admin');
        }
    }
   }


   function DisplayDashboard() {
   	if(!Session::has('administrator_id')) { return Redirect::to('/admin');}
       return View::make('admin.dashboard');
   }




   function Logout() {
     Session::flush();
     Session::save();

     return Redirect::to('admin/dashboard');
   }


}
