<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class scadualInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rr=[];
        // if (App::getLocale() == "en") {

                $rr= [
                    'name' => $this->clinic->doctor->name ?? '',


                    'medical field'=>docFieldsResource::collection($this->clinic->doctor->medicField()->get()),

                    'image' => asset('uploads/doctors/' . $this->clinic->doctor->img) ?? '',
                    'reservation_date' => $this->reservation_date ?? '',
                    'av_day' => $this->reserv_day ?? '',
                    'av_time' => $this->time_from->format('H:i') ?? '',

                ];



        // }
return $rr;
    }
}
