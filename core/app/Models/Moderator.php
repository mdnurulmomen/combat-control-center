<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageIntervention;

class Moderator extends Model
{
   	public function setProfilePictureAttribute($originImageFile)
    {
    	if ($originImageFile) {
    		
    		// $originImageFile = $request->file('picture');
            $imageObject = ImageIntervention::make($originImageFile)->encode('jpg');
            $imageObject->resize(200, 200)->save('assets/moderator/images/profile/'.$originImageFile->hashname());
            $this->attributes['picture'] = $originImageFile->hashname();
    	}
    }
}
