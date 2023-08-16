<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as ImageIntervention;

class AdminPanelSetting extends Model
{
   	protected $guarded = [];

    public function setFaviconImageAttribute($originImageFile)
    {
    	if ($originImageFile) {
    		
            // $originImageFile = $request->file('favicon');
            $imageObject = ImageIntervention::make($originImageFile)->encode('png');

            if (!file_exists('assets/admin/images/settings')) {

                mkdir('assets/admin/images/settings', 0777, true);
            }

            $imageObject->resize(16, 16)->save('assets/admin/images/settings/favicon.png');

            $this->attributes['favicon'] = "favicon.png";
        
    	}
    }
}
