<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageIntervention;

class AdminPanelSetting extends Model
{
   	public function setFaviconImageAttribute($originImageFile)
    {
    	if ($originImageFile) {
    		
            // $originImageFile = $request->file('favicon');
            $imageObject = ImageIntervention::make($originImageFile)->encode('png');
            $imageObject->resize(16, 16)->save('assets/admin/images/settings/favicon.png');

            $this->attributes['favicon'] = "favicon.png";
        
    	}
    }
}
