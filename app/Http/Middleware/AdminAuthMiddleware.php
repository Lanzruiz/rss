<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;
use Hash;
use Response;
use Request;
use Log;
class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {


      //$password = $request->getToken();

      $access_token = Request::header('Authorization');

      Log::debug("access_token");
      Log::debug($access_token);

      $user = DB::table('tblUser')->where('fldUserAPIToken', $access_token)->first();
      //Log::debug("Authetication users");
      //Log::debug(count($user));

           if(count($user) == 1) {

             //echo $client->fldClientID;
             //Auth::loginUsingId(1);

             return $next($request);
             //var_dump(Auth::user());
          } else {
             return Response::json(array(
                 'error' => true,
                 'message' => "Invalid Token Authentication."),
                 200
            );
          }


       die();

      //print_r($request->check());
      //echo $request;
        if(auth()->check()) {
          echo "ok";
           return $next($request);

        } else {
          echo "not ok";
        }

        //return redirect('home');
    }
}
