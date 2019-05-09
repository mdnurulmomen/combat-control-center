<?php

namespace App\Http\Resources\Player;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Weapon;

class PlayerWeapons extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function numberOfWeapons()
    {
        return Weapon::count();
    }


    public function toArray($request)
    {
        // dd($this->resource);

        $array = [];

        for($i=0; $i<$this->numberOfWeapons(); $i++){

            if (in_array($i, $this->resource)) {
                array_push($array, 1);
            }else{
                array_push($array, 0);
            }
        }

        return $array;

        // return parent::toArray($request);
        // return $this->weapon_index;
    }
}
