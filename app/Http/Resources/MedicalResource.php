<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class MedicalResource extends JsonResource
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
        'field_img'=>asset('uploads/medical_fields/' . $this->field_img) ?? '',
        'doctor_count'=>$this->clinics()->count(),
    ];
}else{
    return [
        'id'=>$this->id,
        'field_name'=>$this->field_dtname ?? '',
        'field_img'=>asset('uploads/medical_fields/' . $this->field_img) ?? '',
        'doctor_count'=>$this->clinics()->count(),
    ];
}

    }
}
