<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class MedSearch extends JsonResource
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
        'field_name'=>$this->field_enname ?? '',
        'field_img'=>asset('uploads/medical_fields/' . $this->thumbnail) ?? '',


    ];
}else{
    return [
'id'=>$this->id,
        'field_name'=>$this->field_dtname ?? '',
        'field_img'=>asset('uploads/medical_fields/' . $this->thumbnail) ?? '',


    ];
}

    }
}
