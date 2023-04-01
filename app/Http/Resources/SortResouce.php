<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SortResouce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *'doctor_count'=>$this->repliesCount
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
if(App::getLocale()=="en"){
    return [

        'city'=>$this->en_city ?? '',

    ];
}else{
    return [

        'city'=>$this->dt_city ?? '',
    ];

}

    }
}
