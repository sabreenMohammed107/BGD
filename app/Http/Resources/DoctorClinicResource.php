<?php
namespace App\Http\Resources;

use Carbon\Carbon;
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
                'id'=>$this->clinic_id,
                'clinic_name'=>$this->clinic_name,
                'doctor' => DoctorResource::make($this->doctor),
                'medical field'=>docFieldsResource::collection($this->doctor->medicField()->get()),
                'gallery'=>GalleryResource::collection($this->active_gallery),
                'phone' => $this->phone ?? '',
                'street' => $this->en_street ?? '',
                'postal_code' => $this->postal_code ?? '',
                'google_map' => $this->google_map ?? '',
                'parking_allowed' => (string)$this->parking_allowed ?? '',
                'home_visit_allowed' => (string)$this->home_visit_allowed ?? '',
                'disability_allowed' => (string)$this->disability_allowed ?? '',
                'clinic_status_id' => $this->clinic_status_id ?? '',
                'insurance_type' =>$this->insurance->en_type ?? '',
                'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->en_type : $this->visit_fees  ,
                'avgRating' => round($this->review->avg('stars'),1) ==0 ? 'no patients ratings or reviews yet' : round($this->review->avg('stars'),1),
                'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),

                'av_day' => $this->next_day ?? '',
                'av_time' =>Carbon::parse($this->next_time->time_from)->format('H:i')?? '',

            ];
        }else{
            return [
                'id'=>$this->clinic_id,
                'clinic_name'=>$this->clinic_name,
                'doctor' => DoctorResource::make($this->doctor),
                'medical field'=>docFieldsResource::collection($this->doctor->medicField()->get()),
                'gallery'=>GalleryResource::collection($this->active_gallery),
                'phone' => $this->phone ?? '',

                'postal_code' => $this->postal_code ?? '',
                'google_map' => $this->google_map ?? '',
                'parking_allowed' => (string)$this->parking_allowed ?? '',
                'home_visit_allowed' => (string)$this->home_visit_allowed ?? '',
                'disability_allowed' => (string)$this->disability_allowed ?? '',
                'clinic_status_id' => $this->clinic_status_id ?? '',

                'avgRating' =>  round($this->review->avg('stars'),1) ==0 ? 'noch keine Patientenbewertungen oder Rezensionen' :  round($this->review->avg('stars'),1),
                'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),
                'av_day' => $this->next_day ?? '',

                'av_time' =>Carbon::parse($this->next_time->time_from)->format('H:i')?? '',
                'street' => $this->dt_street ?? '',
                'insurance_type' =>$this->insurance->dt_type ?? '',
                'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->dt_type : (string)$this->visit_fees  ,


            ];
        }

    }
}
