<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class docFieldsResource extends JsonResource
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
        'field_name'=>$this->medical->field_enname,
    ];
}else{
    return [
        'field_name'=>$this->medical->field_dtname,

    ];
}

    }
}
