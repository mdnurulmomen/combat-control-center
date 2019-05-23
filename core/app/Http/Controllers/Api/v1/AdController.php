<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Game\AdCollection;

class AdController extends Controller
{
    public function showAllAd()
    {
        return new AdCollection(Image::orderBy('order', 'ASC')->get());
    }
}
