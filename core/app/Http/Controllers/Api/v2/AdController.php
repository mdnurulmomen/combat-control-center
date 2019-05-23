<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\Game\AdCollection;

class AdController extends Controller
{
    public function showAllAd()
    {
        return new AdCollection(Image::orderBy('order', 'ASC')->get());
    }
}
