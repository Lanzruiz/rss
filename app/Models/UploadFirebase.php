<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use File

class UploadFirebase extends Eloquent
{
	public $timestamps = false;

	public static function upload() {
		 $file = Input::file('video');
		 

		 // if($file != "") {
		 // 	$destinationPath = VIDEO_PATH.$playerID.'/';	
							   
			// $filename = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.'.$file->getClientOriginalExtension();
			// $file->move($destinationPath, $filename);	

		 // }
		 return View::make('upload.upload', compact('file'));


	}

}