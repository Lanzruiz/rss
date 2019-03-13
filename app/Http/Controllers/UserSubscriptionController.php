<?php
/***********************Thomas Woodfin TBLTechNerds.com**************************/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Users;
use App\Models\AlertDetails;
use App\Models\SMS;
use App\Models\Country;
use App\Models\Paypal;
use App\Models\Subscription;
use App\Models\SessionData;

use Response;
use File;
use View;
use Input;
use Validator;
use Redirect;
use Session;
use Mail;

class UserSubscriptionController extends Controller
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
    
    
    public function DisplaySubscription()
    {
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }

        return View::make('front.subscription');
    }

    public function ProcessSubscription($id) {
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }

        $amount = 0;
        $type = "";

        if($id == 1) {
           $amount = 1.99;
           $type = "Bronze Subscription";
        } else if($id == 2) {
          $amount = 14.99;
          $type = "Silver Subscription";
        } else if($id == 3) {
          $amount = 59.99;
          $type = "Gold Subscription";
        } else if($id == 4) {
          $amount = 99.99;
          $type = "Platinum Subscription";
        } else if($id == 5) {
            $amount = 19.99;
            $type = "Diamond Subscription";
        } else if($id == 6) {
            $amount = 140.00;
            $type = "Diamond Subscription (1 Year)";
        }


        $users = Users::find($this->user_id);
        $firstname = "";
        if($users) {
          $firstname = $users->fldUsersFullname;
        }

        $p = new Paypal;
        $p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        //$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        //$p->add_field('business','emmanuel@tbldevs.com');
        $p->add_field('business','Shawn@witnessone.com');
        $p->add_field('return',url('thankyou/payment/paypal'));
        $p->add_field('cancel_return',url('thankyou/declined/paypal'));
        $p->add_field('item_name',$type);
        $p->add_field('first_name',$firstname);
        $p->add_field('last_name','');
        $p->add_field('amount',$amount);
        $p->add_field('curreny_code','USD');
        $p->add_field('receiver_email','Shawn@witnessone.com');
        //$p->add_field('receiver_email','emmanuel@tbldevs.com');
        $p->add_field('image_url',url('public/assets/images/main-logo.png'));
        $p->add_field('custom',$this->user_id);
        $p->submit_paypal_post();
    }


    public function PaypalProcessComplete() {
        $users = self::checkUserLogin();
        if(!$users) {
            return Redirect::to('/');
        }

      $transaction_id =  $_POST['txn_id'];
      $transaction_fee = $_POST['mc_fee'];
      $transaction_gross = $_POST['mc_gross'];
      $payment_status = $_POST['payment_status'];
      $item_name = $_POST['item_name'];
      $custom = $_POST['custom'];

      $date_from = date('Y-m-d');
      $date_to = date('Y-m-d', strtotime('+1 Month'));


      //save this info to subscription table
      $size = 0;
      if($transaction_gross == "1.99") {
         $size = 1;
      } else if($transaction_gross == "14.99") {
        $size = 10;
      } else if($transaction_gross == "59.99") {
        $size = 50;
      } else if($transaction_gross == "99.99") {
        $size = 100;
      } else if($transaction_gross == "19.99") {
          $size = 15;
      } else if($transaction_gross == "140.00") {
          $size = 15;
          $date_to = date('Y-m-d', strtotime('+12 Month'));
      }

      //check if user have existing subscription
      $subscription = Subscription::where('user_id','=',$custom)
                                  ->where('date_to','>=',$date_from)
                                  ->orderBy('id','DESC')
                                  ->first();
      if($subscription) {
        $size = $subscription->subscription_size + $size;
        //$date_from = $subscription->date_from;
        //$date_to = $subscription->date_to;
        //Log::debug($size);
      }

      $subscription = new Subscription;
        $subscription->user_id = $custom;
        $subscription->transaction_id = $transaction_id;
        $subscription->transaction_fee = $transaction_fee;
        $subscription->transaction_gross = $transaction_gross;
        $subscription->payment_status = $payment_status;
        $subscription->type = $item_name;
        $subscription->date_from = $date_from;
        $subscription->date_to = $date_to;
        $subscription->subscription_date = date('Y-m-d');
        $subscription->subscription_size = $size;
      $subscription->save();


      //update firebasase subscription
       //$url = FIREBASE_PATH.'user_subscription/'.$custom.'.json?auth='.FIREBASE_AUTHKEY;
       $url = FIREBASE_PATH.'user_subscription/'.$custom.'.json';
             $arr = array("subscription_size"=>$size,"subscription_date"=>date('Y-m-d'),"date_from"=>$date_from,
                     "date_to"=>$date_to);

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
       //end subscription in firebase



      Session::flash('success','Thank you!, Your payment and ' . $item_name . ' was successfull. You can now enjoy upto ' . $size . 'GB of data');
      return Redirect::to('dashboard/console');

    }

    public function PaypalProcessDeclined() {
        Session::flash('error','Your payment was declined or cancelled. Please try again.');
        return Redirect::to('dashboard/console');
    }

}
