<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class SortResouce extends JsonResource
{
    if (App::getLocale() == "en") {
        return [


            'id'=>$this->id,

            "image" => $this->image ? asset('uploads/users/' . $this->image) : asset('img/default.png') ,




        ];
    } else {
        return [



            'id'=>$this->id,

            "image" => $this->image ? asset('uploads/users/' . $this->image) : asset('img/default.png') ,




        ];
    }

}
}
