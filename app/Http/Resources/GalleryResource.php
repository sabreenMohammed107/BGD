<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *'doctor_count'=>$this->repliesCount
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
if(App::getLocale()=="en"){
    return [

        'image'=>asset('uploads/galleries/' . $this->image) ?? '',
        'active'=>$this->active,

    ];
}else{
    return [

        'image'=>asset('uploads/galleries/' . $this->image) ?? '',
        'active'=>$this->active,
    ];
}

    }
}
