<?php

namespace App\Http\Resources\v2\Player;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Parachute;

class PlayerParachutes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function numberOfParachutes()
    {
        return Parachute::count();
    }


    public function toArray($request)
    {
        // dd($this->resource);

        $array = [];

        for($i=0; $i<$this->numberOfParachutes(); $i++){

            if (in_array($i, $this->resource)) {
                array_push($array, 1);
            }else{
                array_push($array, 0);
            }
        }

        return $array;

        // return parent::toArray($request);
        // return $this->parachute_index;
    }
}
