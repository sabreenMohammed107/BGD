<?php
namespace App\Http\Resources;

use Carbon\Carbon;
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
        if (App::getLocale() == "en") {

                $rr= [
                    'name' => $this->clinic->doctor->name ?? '',


                    'medical field'=>docFieldsResource::collection($this->clinic->doctor->medicField()->get()),

                    'image' => asset('uploads/doctors/' . $this->clinic->doctor->img) ?? '',

                    'status'=>$this->status->en_status ?? '',
                    'reservation_date' => $this->reservation_date ?? '',
                    'av_day' => $this->reserv_day ?? '',
                    'av_time' =>Carbon::parse($this->time_from)->format('H:i')?? '',
                    'street' => $this->clinic->en_street ?? '',
                    'google_map' => $this->clinic->google_map ?? '',
                    'latitude'=> $this->clinic->latitude ?? '',
                    'longitude'=> $this->clinic->longitude ?? '',
                    'postal_code' => $this->clinic->postal_code ?? '',
                    'city'=>$this->clinic->city->en_city ?? '',
                ];



        }else{
            $rr= [
                'name' => $this->clinic->doctor->name ?? '',


                'medical field'=>docFieldsResource::collection($this->clinic->doctor->medicField()->get()),

                'image' => asset('uploads/doctors/' . $this->clinic->doctor->img) ?? '',

                'status'=>$this->status->dt_status ?? '',
                'reservation_date' => date_format(date_create($this->reservation_date), "D M Y"),
                'av_day' => $this->reserv_day ?? '',
                'av_time' =>Carbon::parse($this->time_from)->format('H:i')?? '',
                'street' => $this->clinic->dt_street ?? '',
                    'google_map' => $this->clinic->google_map ?? '',
                    'latitude'=> $this->clinic->latitude ?? '',
                    'longitude'=> $this->clinic->longitude ?? '',
                    'postal_code' => $this->clinic->postal_code ?? '',
                    'city'=>$this->clinic->city->dt_city ?? '',

            ];
        }
return $rr;
    }
}
