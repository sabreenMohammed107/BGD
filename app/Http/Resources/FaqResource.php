<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class FaqResource extends JsonResource
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
        "en_question"=>$this->en_question ?? '',

        'en_answer'=>$this->en_answer ?? '',

    ];
}else{
    return [

        'dt_question'=>$this->dt_question ?? '',

        'dt_answer'=>$this->dt_answer ?? '',
    ];
}


    }
}
