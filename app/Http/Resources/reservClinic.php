<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class reservClinic extends JsonResource
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




                'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->en_type : (string)$this->visit_fees  ,

                'avgRating' => round($this->review->avg('stars'),1) ==0 ? 'no patients ratings or reviews yet' : round($this->review->avg('stars'),1),
                'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),



            ];

        }else{
    return [

        'id'=>$this->id,
        'name' =>  $this->doctor->name ?? '',
        'image' => asset('uploads/doctors/' . $this->doctor->img) ?? '',
        'medical field'=>docFieldsResource::collection($this->doctor->medicField()->get()),




        'visit_fees' => $this->insurance_type_id==1 ?  $this->insurance->dt_type : (string)$this->visit_fees  ,

        'avgRating' =>  round($this->review->avg('stars'),1) ==0 ? 'noch keine Patientenbewertungen oder Rezensionen' :  round($this->review->avg('stars'),1),
        'reviewCount' => $this->review->count()==0 ? '0' : $this->review->count(),


    ];
}

    }
}
