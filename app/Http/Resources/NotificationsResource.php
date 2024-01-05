<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
class NotificationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(App::getLocale()=="en"){
            return [



                'title'=>$this->title_en ?? '',


                'notifiy_date' =>date_format(date_create($this->created_at), "d.m.Y"),

            ];

        }
        else{
            return [


                'title' => $this->title_dt ?? '',


                'notifiy_date' =>date_format(date_create($this->created_at), "d.m.Y"),

            ];

        }



    }
}
