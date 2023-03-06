<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DoctorClinicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (App::getLocale() == "en") {
            return [
                'id'=>$this->id,
                'doctor' => DoctorResource::make($this->doctor),
                'phone' => $this->phone ?? '',
                'en_street' => $this->en_street ?? '',
                'dt_street' => $this->dt_street ?? '',
                'postal_code' => $this->postal_code ?? '',
                'google_map' => $this->google_map ?? '',
                'parking_allowed' => $this->parking_allowed ?? '',
                'home_visit_allowed' => $this->home_visit_allowed ?? '',
                'disability_allowed' => $this->disability_allowed ?? '',
                'clinic_status_id' => $this->clinic_status_id ?? '',
                'insurance_type_id' =>$this->insurance->en_type ?? '',
                'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->en_type : $this->visit_fees  ,
                'avgRating' => round($this->review->avg('stars'),1) ?? '',
                'reviewCount' => $this->review->count(),
                'av_day' => $this->next_day ?? '',
                'av_time' => $this->next_time->time_from ?? '',

            ];
        }

    }
}
