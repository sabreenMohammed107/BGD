<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DayResource extends JsonResource
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
      'id'=>$this->id,
        'day_name'=>$this->en_day ?? '',


    ];
}else{
    return [
'id'=>$this->id,
'day_name'=>$this->dt_day ?? '',


    ];
}

    }
}
