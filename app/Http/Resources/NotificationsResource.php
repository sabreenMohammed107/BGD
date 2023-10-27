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
        dd(App::getLocale());
        if(App::getLocale()=="en"){
            return [



                'title'=>$this->title_en ?? '',


                'notifiy_date' =>$this->created_at,

            ];

        }
        else{
            return [


                'title' => $this->title_dt ?? '',


                'notifiy_date' =>$this->created_at,

            ];

        }



    }
}
