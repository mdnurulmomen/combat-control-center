<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Intervention\Image\Facades\Image as ImageIntervention;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guarded=['id'];

    public function setProfilePictureAttribute($originImageFile)
    {
    	if ($originImageFile) {
    		
    		// $originImageFile = $request->file('picture');
            $imageObject = ImageIntervention::make($originImageFile);
            $imageObject->resize(200, 200)->save('assets/admin/images/profile/'.$originImageFile->hashname());

            $this->attributes['picture'] = $originImageFile->hashname();
    	}
    }
}
