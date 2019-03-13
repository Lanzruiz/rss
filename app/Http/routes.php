<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::group(array('middleware' => 'secure-page'), function() {
   // Route::get('/clean-firebase', 'UserController@AddToCleanFirebaseQue');
   // Route::get('/fetch-clear-user', 'UserController@scheduleFeedCleaning');
   // Route::get('/test-alvin', 'Usercontroller@TestAlvin');
   Route::get('/tests3', 'UserController@TestS3');
   Route::get('/', 'UserController@login');
   Route::post('/', 'UserController@checkAccess');


   Route::get('/forgot-password', 'UserController@ForgotPassword');
   Route::post('/forgot-password', 'UserController@CheckForgotPassword');

   Route::get('/new-password/{security}', 'UserController@ResetPassword');
   Route::post('/new-password/{security}', 'UserController@SaveNewPassword');

   Route::get('/faq', 'UserController@faq');

   Route::get('/registration', 'UserController@registration');
   Route::post('/registration', 'UserController@saveRegistration');

   Route::get('/security_code', 'UserController@securityCode');
   Route::post('/security_code', 'UserController@checkSecurityCode');

   Route::get('/superuser', 'AdministratorController@SuperUser');
   Route::post('/superuser', 'AdministratorController@CheckSuperUser');

    Route::get('/dllp', 'UserController@downloadAPK');
    Route::get('/dllp_weseeyouapp', 'UserController@downloadIPA');

    Route::get('test-encrpytion', 'EncryptionController@TestEncryption');

    Route::get('/subscription', 'UserSubscriptionController@DisplaySubscription');
    Route::get('/subscription/process/{id}', 'UserSubscriptionController@ProcessSubscription');
      Route::post('/thankyou/payment/paypal','UserSubscriptionController@PaypalProcessComplete');
      Route::get('/thankyou/declined/paypal','UserSubscriptionController@PaypalProcessDeclined');
//});
    /*
    Route::get('/', 'UserController@login');
    Route::post('/', 'UserController@checkAccess');

    Route::get('/dllp', 'UserController@downloadAPK');

    Route::get('/registration', 'UserController@registration');
    Route::post('/registration', 'UserController@saveRegistration');

    Route::get('/security_code', 'UserController@securityCode');
    Route::post('/security_code', 'UserController@checkSecurityCode');

    Route::get('/superuser', 'AdministratorController@SuperUser');
    Route::post('/superuser', 'AdministratorController@CheckSuperUser');
    */

     Route::get('video/streaming', 'UploadFirebaseAPI@videoStream');
     Route::get('glassmap/{accesscode}', 'UserController@displayGlassMap');
     Route::get('glassmap-new/{accesscode}', 'UserController@displayGlassMapNew');



    Route::group(array('prefix' => 'dashboard'), function() {
        Route::get('console', 'UserController@console');
        Route::get('package', 'UserController@package');
        Route::get('users', 'UserController@listUsers');
        Route::post('users', 'UserController@addNewUsers');
        Route::get('users/edit/{id}', 'UserController@editUsers');
        Route::post('users/edit/{id}', 'UserController@updateUsers');
        Route::get('users/delete/{id}', 'UserController@deleteUsers');
        Route::get('users/clean_feeds/{id}', 'UserController@cleanUserFeeds');
        Route::get('profile', 'UserController@profile');
        Route::post('profile', 'UserController@updateProfile');
        Route::get('logout', 'UserController@logout');
        Route::get('archived', 'UserController@displayArchive');
        Route::get('error', 'UserController@displayError');

        Route::post('archived', 'UserController@UpdateEventName');
        Route::post('archived-agent', 'UserController@UpdateEventNameAgent');

        Route::get('delete-selected-event/{access_code}/{event_id}', 'UserController@DeleteSelectedEvent');

        Route::get('sms', 'SMSController@displaySMS');
        Route::post('sms', 'SMSController@sendSMS');
        Route::get('reply/{accesscode}', 'SMSController@displayReplySMS');
        Route::post('reply/{accesscode}', 'SMSController@sendReplySMS');

        Route::get('check_reply_sms/{accesscode}', 'SMSController@checkReplySMS');
        Route::get('commander-ptt/clear_audio', 'UserController@ClearPTTAudio');
        Route::get('clean-all-feeds','UserController@CleanAllFeeds');

        

     });

     Route::group(array('prefix' => 'api/v1'), function() {
        Route::post('user/access_code', 'UploadFirebaseAPI@checkAccessCode');
        Route::post('streaming-security', 'UploadFirebaseAPI@streamingSecurity');
        //Route::post('display_events_user_video', 'UserController@displayVideoByUserEvents');
        Route::post('commander/login', 'UserAPIController@CheckLogin');
        Route::get('commander/clear_audio/{commander_id}', 'UserAPIController@ClearAudio');

        Route::post('login', 'UserAPIController@UserLogin');

     });

     Route::group(array('prefix' => 'api/v1', 'middleware' => 'adminauth'), function() {
        Route::post('upload/video', 'UploadFirebaseAPI@upload');
        Route::post('user/location', 'UploadFirebaseAPI@location');
        Route::post('stop/streaming', 'UploadFirebaseAPI@stopStreaming');
        Route::post('start/streaming', 'UploadFirebaseAPI@startStreaming');
        Route::post('stop/streaming_web', 'UploadFirebaseAPI@stopStreamingWeb');
        Route::get('transport/threat/{accesscode}', 'UploadFirebaseAPI@transportThreat');
        Route::post('check-data-usage', 'UploadFirebaseAPI@CheckUserDataUsage');

        //for dashboard api
        Route::post('display_events_user', 'UserController@displayEventsByUser');
        Route::post('bRecords', 'UserController@bRecords');
        Route::post('multiple-location', 'UserController@UserMultipleLocationKey');
        Route::get('delete-selected-event/{access_code}/{event_id}', 'UserController@DeleteSelectedEvent');
        Route::post('tRecords', 'UserController@tRecords');
        Route::post('mobile_save', 'UploadFirebaseAPI@updateUploadMobile');

        Route::get('delete_firebase/{access_code}', 'UploadFirebaseAPI@deleteFirebaseData');
        Route::get('delete_user_data/{access_code}', 'UploadFirebaseAPI@deleteFirebaseAndArchive');
        Route::get('getAlertDetails', 'UploadFirebaseAPI@getAlertDetails');
        Route::post('firstPIDCheck', 'UserController@firstPIDCheck');
        Route::post('firstOfficerCheck', 'UserController@firstOfficerCheck');
        Route::post('actionAgAllFeed', 'UserController@actionAgAllFeed');
        Route::get('upload/display', 'UploadFirebaseAPI@displayUpload');
        Route::post('trAlertStatusFeed', 'UserController@trAlertStatusFeed');

        Route::post('getUser', 'UserController@displayUserByType');

        Route::get('display-user-by-commander', 'UserAPIController@DisplayAllUser');
        Route::get('display-commander','UserAPIController@DisplayCommander');

        Route::post('invite-friends', 'UserController@InviteFriends');
                  
       Route::post('check-ongoing-feeds', 'UploadFirebaseAPI@CheckCurrentDataUsage');

     });

     Route::group(array('prefix' => 'admin'), function() {
         Route::get('/', 'AdministratorController@Login');
         Route::post('/', 'AdministratorController@CheckLogin');
         Route::get('/dashboard', 'AdministratorController@DisplayDashboard');
         Route::get('/settings/{id}/delete', 'AdministratorController@destroy');
         Route::resource('/settings', 'AdministratorController');
         Route::get('/commander/users/{id}', 'CommanderController@DislayAllUsers');
         Route::resource('/commander', 'CommanderController');
         Route::get('/clean_all_feeds', 'CommanderController@CleanAllFeeds');
         Route::get('/clean-all-feeds-commander/{id}', 'CommanderController@CleanAllFeedsByCommanderID');
         Route::get('/clean-all-feeds-user/{id}', 'CommanderController@CleanAllFeedsByUserID');
          Route::get('/logout', 'AdministratorController@Logout');

          Route::get('/newsletter/{id}/delete', 'NewsletterController@destroy');
          Route::get('/newsletter/{id}/send', 'NewsletterController@DisplayNewsletter');
          Route::post('/newsletter/{id}/send', 'NewsletterController@SendNewsletter');
          Route::resource('/newsletter', 'NewsletterController');
     });

     Route::get('test_streaming', 'AdministratorController@TestStreaming');

    //  Route::get('/{slug}', function () {
    //       return redirect('/');
    //   });

     define('VIDEO_PATH', 'public/uploads/video/');
     define('AUDIO_PATH', 'public/uploads/audio/');
     define('FIREBASE_PATH', 'https://smartglass-aed6d.firebaseio.com/');
     define('FROM_EMAIL', 'info@raptorsecuritysoftware.com');

     define('PRODUCT_TITLE', 'RaptorSecuritySoftware');
     define('BCC', 'Tommy.woodfin@gmail.com');
     define('LIVECONSOLE', 'Live Console');
     define('ARCHIVEDCONSOLE', 'Archived Console');
     define('APPDownload','');
     //define('STREAMINGIPADDRESS','54.200.174.122');
     //define('STREAMINGIPADDRESS','34.213.186.164');
     //define('STREAMINGIPADDRESS','54.200.140.190');
    define('STREAMINGIPADDRESS','54.71.234.227');
     define('FIREBASE_AUTHKEY','Y9HzHk1jcjKHy5bjESCR9B01QoK4AP9U8KF4OAAi');
    //define('FIREBASE_AUTHKEY','GOIHuYcEKJcN1OEsRhi8SmiKw0YPuKIzzlu5xwih');

     date_default_timezone_set('America/New_York');
