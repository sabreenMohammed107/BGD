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

        'field_enname'=>$this->field_enname ?? '',
        'field_dtname'=>$this->field_dtname ?? '',
        'field_img'=>asset('uploads/medical_fields/' . $this->field_img) ?? '',
        'doctor_count'=>$this->doctors()->count(),
    ];
}

    }
}
