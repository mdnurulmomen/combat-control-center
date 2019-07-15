<?php

namespace App\Http\Controllers\Api\v2;

use App\Models\TreasureType; 
use Illuminate\Http\Request;
use App\Http\Traits\RetrieveToken;
use App\Http\Controllers\Controller;
use App\Http\Resources\v2\Game\VendorsResource;

class VendorController extends Controller
{
   	use RetrieveToken;

   	public function showAllRelatedVendors(Request $request)
    {
        /*
        
        $payload = $this->retrieveToken($postman);

        if (is_null($payload)) {
            return response()->json(['error'=>'Invalid token'], 422);
        }

        $request = new Request($payload);
        
        */


        $request->validate([
            'type'=>'required|exists:treasure_types,treasure_type_name'
        ]);

        $treasureType = TreasureType::where('treasure_type_name', $request->type)->first();
        $vendors = $treasureType->relatedVendors;

        if ($vendors) {
            
            return ['vendors' => VendorsResource::collection($treasureType->relatedVendors)];

        }

        return response()->json([
            'message' => 'No agent for this type'
        ]);

    }
}
