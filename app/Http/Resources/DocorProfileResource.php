<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class DocorProfileResource extends JsonResource
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
                'name' =>  $this->doctor->name ?? '',
                'image' => asset('uploads/doctors/' . $this->doctor->img) ?? '',
                'medical field'=>docFieldsResource::collection($this->doctor->medicField()->get()),
                'gallery'=>GalleryResource::collection($this->gallery),
                'insurance_type' =>$this->insurance->en_type ?? '',
                'street' => $this->en_street ?? '',
                'google_map' => $this->google_map ?? '',

                'parking_allowed' => (string)$this->parking_allowed ?? '',
                'home_visit_allowed' => (string)$this->home_visit_allowed ?? '',
                'disability_allowed' => (string)$this->disability_allowed ?? '',
                'overview' => $this->doctor->en_overview ?? '',

                'phone' => $this->phone ?? '',
                'postal_code' => $this->postal_code ?? '',

                'reservation_notes' => $this->en_reservation_notes ?? '',



                'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->en_type : (string)$this->visit_fees  ,

                'avgRating' => round($this->review->avg('stars'),1) ==0 ? 'no patients ratings or reviews yet' : round($this->review->avg('stars'),1),
                'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),
                'reviews' =>  ReviewResource::collection($this->review),


            ];

        }else{
    return [






        'id'=>$this->id,
        'name' =>  $this->doctor->name ?? '',
        'image' => asset('uploads/doctors/' . $this->doctor->img) ?? '',
        'medical field'=>docFieldsResource::collection($this->doctor->medicField()->get()),
        'gallery'=>GalleryResource::collection($this->gallery),

        'insurance_type' =>$this->insurance->dt_type ?? '',
        'street' => $this->dt_street ?? '',
        'google_map' => $this->google_map ?? '',

        'parking_allowed' => (string)$this->parking_allowed ?? '',
        'home_visit_allowed' => (string)$this->home_visit_allowed ?? '',
        'disability_allowed' => (string)$this->disability_allowed ?? '',
        'overview' => $this->doctor->dt_overview ?? '',

        'phone' => $this->phone ?? '',
        'postal_code' => $this->postal_code ?? '',

        'reservation_notes' => $this->dt_reservation_notes ?? '',




        'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->dt_type : (string)$this->visit_fees  ,

        'avgRating' =>  round($this->review->avg('stars'),1) ==0 ? 'noch keine Patientenbewertungen oder Rezensionen' :  round($this->review->avg('stars'),1),
        'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),
        'reviews' =>  ReviewResource::collection($this->review),

    ];
}

    }
}
